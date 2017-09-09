/*
  socket.h:the base socket function wrapper
*/

/* 
  Copyright (C) 2008-2, Han.zhihong, Developer. Created 2008. 
  All rights reserved.

  License to copy and use this software is granted provided that it
  is identified as the "Han.zhihong. Message-Digest
  Algorithm" in all material mentioning or referencing this software
  or this function.
  
  Han.zhihong. makes no representations concerning either
  the merchantability of this software or the suitability of this
  software for any particular purpose. It is provided "as is"
  without express or implied warranty of any kind.
	  
  These notices must be retained in any copies of any part of this
  documentation and/or software.
*/

#include "socket.h"
#include <stdio.h>

int g_nCount = 0;

bool zhSock_NetStartUp(int VersionHigh,int VersionLow)
{
#ifdef _WIN32
	unsigned short wVersionRequested;
	WSADATA wsaData;
	int err;
 
	wVersionRequested = MAKEWORD(VersionHigh,VersionLow);
    err=WSAStartup(wVersionRequested, &wsaData);
	
	/* startup failed */
	if (err!=0)									
	{
		PRINTF("WSAStartup Error");
		WSACleanup();
		return false;
	}

	/* version error */
	if (LOBYTE(wsaData.wVersion)!= VersionLow ||
        HIBYTE(wsaData.wVersion)!= VersionHigh ) 
	{
		ZH_NET_DEBUG_PRINTF("WSAStartup Version Error");
		WSACleanup();
		return false;
	}
	ZH_NET_DEBUG_PRINTF("WSAStartup OK");
#endif
	return true;
}

bool zhSock_NetCleanUp()
{
#ifdef _WIN32	
	WSACleanup();
#endif
	return true;
}

bool zhSockInit(SOCKET *s,EzhNetType protocol)
{
	if (g_nCount++==0)
		if (!zhSock_NetStartUp(1,1)) return false;

	switch (protocol)
	{
	case ezhNetTypeUDP:
		{
			*s=socket(AF_INET,SOCK_DGRAM,IPPROTO_UDP);
		}
		break;
	case ezhNetTypeTCP:
		{
			*s=socket(AF_INET,SOCK_STREAM,IPPROTO_TCP);
		}
		break;
	} 
	
	if(*s==INVALID_SOCKET) 
	{
		return false;
	}
	return true;
}

bool zhSockBindAddr(SOCKET s,char *ip,int port)
{
	struct sockaddr_in addrLocal;
	addrLocal.sin_family=AF_INET;
	addrLocal.sin_port=htons(port);
	if(ip)
	{
		addrLocal.sin_addr.s_addr=inet_addr(ip);
	}
	else
	{
		addrLocal.sin_addr.s_addr=htonl(INADDR_ANY);
	}
	if(bind(s,(SOCKADDR *)&addrLocal,sizeof(addrLocal))==SOCKET_ERROR)
	{
		ZH_NET_DEBUG_PRINTF("bind socket error");
		return false;
	}
	return true;
}

bool zhSockListen(SOCKET s)
{
	if(listen(s,SOMAXCONN)==SOCKET_ERROR)
	{
		ZH_NET_DEBUG_PRINTF("NetSocket:listen error");
		return false;
	}
	return true;
}

bool zhSockConnect(SOCKET s,char *host, int port, unsigned long ip)
{
	struct sockaddr_in addrRemote;
	char *ip_str;
	int err;

	ip_str=NULL;

	memset(&addrRemote,0,sizeof(addrRemote));
	addrRemote.sin_family=AF_INET;
	addrRemote.sin_port=htons(port);
	
	if(host)
		addrRemote.sin_addr.s_addr = inet_addr(host);
	else
		addrRemote.sin_addr.s_addr = ip;
	
	if(addrRemote.sin_addr.s_addr==INADDR_NONE)
	{
		if(!host) return false;
		ip_str=zhSockGetIp(host);
		if(!ip_str) return false;
        addrRemote.sin_addr.s_addr=inet_addr(ip_str);
        ZH_NET_DEBUG_PRINTF("host:%s to ip:%s",host,ip_str); 
	}
	
	if(connect(s,(SOCKADDR *)&addrRemote,sizeof(addrRemote))==SOCKET_ERROR)
	{
		err = GETERROR;
		if (err != CONN_INPRROGRESS)
		{
			ZH_NET_DEBUG_PRINTF("socket connect error = %d",err); 
			return false;
		}
	}
	return true;
}


bool zhSockBlockingConnect(SOCKET s,char *host,int port, unsigned long ip, int timeout_second)
{
    if (!zhSockSetNonBlocking(s,true))
    {
        ZH_NET_DEBUG_PRINTF("set non block failed.");
    }
    
    if(zhSockConnect(s,host,port,ip)==false)
    {
        return false;
    }   
    
    // restart the socket mode
    if (!zhSockSetNonBlocking(s,false))
    {
        ZH_NET_DEBUG_PRINTF("set non block failed.");
    }

    // check if the socket is ready
    if(zhSockCanWrite(s,timeout_second,0))
    {
        return true;
    }
    
    return false;
}

/*
 * return value 
 * =  0 send failed
 * >  0	bytes send
 * = -1 net dead
 */
int zhSockSend(SOCKET s,char *buf, int len)
{
	int ret;

	if (!zhSockCanWrite(s,0,0)) return 0;
	/*
	in linux be careful of SIGPIPE
	*/
	ret = send(s,buf,len,0);
	if (ret==SOCKET_ERROR)
	{
		int err=GETERROR;
		if (err==WSAEWOULDBLOCK) return 0;
		return -1;
	}
	return ret;
}

/*
 * return value 
 * =  0 recv failed
 * >  0	bytes recv
 * = -1 net dead
 */
int zhSockRecv(SOCKET s,char *buf, int buf_len)
{
	int ret;

	if (zhSockCanRead(s,0,0)==false) 
		return 0;

	/* in linux be careful of SIGPIPE */
	ret = recv(s,buf,buf_len,0);
	
	if (ret==0)
	{
		/* remote closed */
		return -1;
	}

	if (ret==SOCKET_ERROR)
	{
		int err=GETERROR;
		if (err!=WSAEWOULDBLOCK)
		{
			return -1;
		}
	}
	return ret;
}


bool zhSockCanRead(SOCKET s,int tv_sec,int tv_usec)
{
	int ret;
	fd_set readfds;
	struct timeval timeout;

	timeout.tv_sec=tv_sec;
	timeout.tv_usec=tv_usec;
	FD_ZERO(&readfds);
	FD_SET(s,&readfds);
	ret = select(FD_SETSIZE,&readfds,NULL,NULL,&timeout);
	if(ret > 0 && FD_ISSET(s,&readfds))
		return true;
	else 
		return false;
}

bool zhSockCanWrite(SOCKET s,int tv_sec,int tv_usec)
{
	int ret;

	fd_set writefds;
	struct timeval timeout;

	timeout.tv_sec=tv_sec;
	timeout.tv_usec=tv_usec;
	FD_ZERO(&writefds);
	FD_SET(s,&writefds);
	ret = select(FD_SETSIZE,NULL,&writefds,NULL,&timeout);
	if(ret > 0 && FD_ISSET(s,&writefds))
		return true;
	else 
		return false;
}

bool zhSockShutdown(SOCKET s,EzhNetShutdown shut)
{
	if(0==shutdown(s,shut))
	{
		return true;
	}
	else
	{
		return false;
	}
}

bool zhSockClose(SOCKET s)
{
	if (s == INVALID_SOCKET) return false;
	CLOSESOCKET(s);
	zhSockReset(s);
	if (--g_nCount==0)
		zhSock_NetCleanUp();
	return true;
}

SOCKET zhSockAccept(SOCKET s)
{
	struct sockaddr_in addr;
	int len = sizeof(addr);
	SOCKET tmp;
	tmp = accept(s,(SOCKADDR *)&addr,(socklen_t *)&len);
	if (tmp == INVALID_SOCKET || tmp == 0)
	{
		//PRINTF("accept error");
		return 0;
	}
	g_nCount++;
	return tmp;	
}

int zhSockSendTo(SOCKET s,char *buf, int len, struct sockaddr_in *addr)
{
	int ret;
	int err;
	if (!zhSockCanWrite(s,0,0)) return 0;

	ret = sendto(s,buf,len,0,(SOCKADDR *)addr,sizeof(struct sockaddr_in));
	if (ret==SOCKET_ERROR)
	{
		err=GETERROR;
		if (err!=WSAEWOULDBLOCK)
		{
			return -1;
		}
	}
	return ret;
}

int zhSockRecvFrom(SOCKET s,char *buf, int buf_len, struct sockaddr_in *addr ,int *addrlen)
{
	int ret;
	if (!zhSockCanRead(s,0,0)) return 0;

	ret = recvfrom(s,buf,buf_len,0,(SOCKADDR *)addr,(socklen_t *)addrlen);
	if (ret==SOCKET_ERROR)
	{
		int err=GETERROR;
		if (err!=WSAEWOULDBLOCK)
		{
			return -1;
		}
	}
	return ret;
}

bool zhSockHasExcept(SOCKET s,int tv_sec,int tv_usec)
{
	int ret;
	fd_set exceptfds;
	struct timeval timeout;

	timeout.tv_sec=tv_sec;
	timeout.tv_usec=tv_usec;
	FD_ZERO(&exceptfds);
	FD_SET(s,&exceptfds);
	ret = select(FD_SETSIZE,NULL,NULL,&exceptfds,&timeout);
	if(ret > 0 && FD_ISSET(s,&exceptfds))
		return true;
	else 
		return false;
}


void zhSockReset(SOCKET s)
{
	s = INVALID_SOCKET;
}

bool zhSockSetNonBlocking(SOCKET s,bool bSetBlock)
{
	/* set to nonblocking mode */
	u_long arg;
	arg=bSetBlock?1:0;
	if (IOCTLSOCKET(s,FIONBIO,&arg)==SOCKET_ERROR)
	{
		return false;
	}
	else
	{
		return true;
	}
}

bool zhSockSetSendBufferSize(SOCKET s,int len)
{
	int ret;
	ret = setsockopt(s,SOL_SOCKET,SO_SNDBUF,(char *)&len,sizeof(len));
	if (ret == SOCKET_ERROR) return false;
	return true;
}

bool zhSockSetRecvBufferSize(SOCKET s,int len)
{
	int ret;
	ret = setsockopt(s,SOL_SOCKET,SO_RCVBUF,(char *)&len,sizeof(len));
	if (ret == SOCKET_ERROR) return false;
	return true;
}

/* 
 * get local address 
 */
bool zhSockGetLocalAddr(SOCKET s,char *addr,unsigned  short *port, unsigned long *ip)
{
	char *tmp;
	struct sockaddr_in addrLocal;
	socklen_t len = sizeof(addrLocal);
	if(getsockname(s,(SOCKADDR*)&addrLocal,&len)==SOCKET_ERROR)
		return false;
	
	tmp = inet_ntoa(addrLocal.sin_addr);
	if(!tmp) 
		return false;
	if(addr) 
		strcpy(addr,tmp);
	if(port)
		*port = ntohs(addrLocal.sin_port);
	if(ip) 
		*ip = addrLocal.sin_addr.s_addr;
	return true;
}

/* 
 * get remote address 
 */
bool zhSockGetRemoteAddr(SOCKET s,char *addr,unsigned short *port,unsigned long *ip)
{
	struct sockaddr_in addrRemote;
	char *tmp;
	int len = sizeof(addrRemote);
	if(getpeername(s,(struct sockaddr *)&addrRemote,(socklen_t *)&len)==SOCKET_ERROR)
		return false;
	
	tmp = inet_ntoa(addrRemote.sin_addr);
	if(!tmp) 
		return false;
	if(addr)
		strcpy(addr,tmp);
	if(port)
		*port = ntohs(addrRemote.sin_port);
	if(ip)
		*ip = addrRemote.sin_addr.s_addr; 
	return true;
}

void zhSockAddrToPram(const struct sockaddr_in *addr,char*ip,unsigned short *port)
{
	if(ip)
	{
		strcpy(ip,inet_ntoa(addr->sin_addr));
	}
	if(port)
	{
		*port=ntohs(addr->sin_port);
	}
}
void zhSockPramToAddr(const char*ip,unsigned short port,struct sockaddr_in *addr)
{
	memset(addr,0,sizeof(struct sockaddr_in));
	addr->sin_addr.s_addr=inet_addr(ip);
	addr->sin_port=htons(port);
	addr->sin_family=AF_INET;
}

bool zhSockSetReuseAddr(SOCKET s,bool reuse)
{
#ifndef _WIN32
	/* only useful in linux */
	unsigned int len;
	int opt;
	opt = 0;
	len = sizeof(opt);

	if(reuse) opt = 1;
	if(setsockopt(s,SOL_SOCKET,SO_REUSEADDR,
		(const void*)&opt,len)==SOCKET_ERROR)
	{
		return false;
	}
	else
	{
		return true;
	}
#endif
	return true;
}

int zhSockGetCount()
{
	return g_nCount;
}

char* zhSockGetIp(char*host)
{
#ifdef _WIN32
	WSADATA wsaData;
	PHOSTENT hostinfo; 
	char*ip;
	unsigned long lgIP;
	ip=NULL;
	lgIP = inet_addr(host);   
	//输入的IP字符串,这是适应WINCE
	if(lgIP != INADDR_NONE)  
	{
		return host;
	}

	if(WSAStartup(MAKEWORD(2,0), &wsaData)== 0)
	{ 
		if((hostinfo = gethostbyname(host)) != NULL)
		{
			ip = inet_ntoa (*(struct in_addr *)*hostinfo->h_addr_list); 
		} 
		WSACleanup();
	}
	return ip;
#else
    struct hostent *hostInfo;    
    struct ifreq req;
    int sock;
	char *ip;
	
    if (host == NULL) return NULL;
    
    if (strcmp(host, "localhost") == 0) {
        sock = socket(AF_INET, SOCK_DGRAM, 0);
        strncpy(req.ifr_name, "eth0", IFNAMSIZ);
		
        if ( ioctl(sock, SIOCGIFADDR, &req) < 0 ) {
            ZH_NET_DEBUG_PRINTF("ioctl error: %s", strerror (errno));
            return NULL;
        }
		
        ip = (char *)inet_ntoa(*(struct in_addr *) &((struct sockaddr_in *) &req.ifr_addr)->sin_addr);
        shutdown(sock, 2);
        close(sock);
    } else {
        hostInfo = gethostbyname(host);
        if (hostInfo == NULL) return NULL;
        ip = (char *)inet_ntoa(*(struct in_addr *)(hostInfo->h_addr));
    }
    return ip;
#endif
}
