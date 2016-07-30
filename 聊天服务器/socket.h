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

#ifndef __ZH_NET_SOCKET_H__
#define __ZH_NET_SOCKET_H__
#ifdef __cplusplus
extern "C"{
#endif

#include "platform.h"

#ifdef _WIN32
	/*
	for windows
	*/
	#include <winsock.h>
	#define GETERROR			WSAGetLastError()
	#define CLOSESOCKET(s)		closesocket(s)
	#define IOCTLSOCKET(s,c,a)  ioctlsocket(s,c,a)
	#define CONN_INPRROGRESS	WSAEWOULDBLOCK
	typedef int socklen_t;

	//#pragma comment(lib, "Ws2.lib") //wince	
	#pragma comment(lib, "Ws2_32.lib") //win32
#else
	/*
	for linux
	*/
	#include <sys/time.h>
	#include <stddef.h>
	#include <unistd.h>
	#include <stdlib.h>
	#include <sys/wait.h>

	#define TRUE  1
	#define FALSE 0

	/*
	for socket
	*/
	#include <sys/socket.h>
	#include <netinet/in.h>
	#include <unistd.h>
	#include <sys/ioctl.h>
	#include <netdb.h>
	#include <sys/errno.h>
	#include <arpa/inet.h>
	#include <net/if.h>

	typedef int SOCKET;
	typedef struct sockaddr_in			 sockaddr_in;
	typedef struct sockaddr			SOCKADDR;
	#define INVALID_SOCKET	    (-1)
	#define SOCKET_ERROR        (-1)
	#define GETERROR			errno
	#define WSAEWOULDBLOCK		EWOULDBLOCK
	#define CLOSESOCKET(s)		close(s)
	#define IOCTLSOCKET(s,c,a)  ioctl(s,c,a)
	#define CONN_INPRROGRESS	EINPROGRESS
#endif

typedef enum _EzhNetType
{
	ezhNetTypeUDP=1,
	ezhNetTypeTCP=2
}EzhNetType;

typedef enum _EzhNetShutdown
{
	ezhNetShutDownRD=0,		//�ر�sockfd�ϵĶ����ܣ���ѡ�������sockfd���ж�������
	ezhNetShutDownWR=1,		//�ر�sockfd��д���ܣ���ѡ�������sockfd����д������
	ezhNetShutDownRDWR=2	//�ر�sockfd�Ķ�д���ܡ�
}EzhNetShutdown;

#define		ZH_SOCK_UDP		ezhNetTypeUDP
#define		ZH_SOCK_TCP		ezhNetTypeTCP

/*
 *initizal socket
 *
 *
*/

bool zhSockInit(SOCKET *s,EzhNetType protocol);

/*
 *shutdown network socket
 *
 *
*/
bool zhSockShutdown(SOCKET s,EzhNetShutdown shut);

/*
 *close network socket
 *
 *
*/
bool zhSockClose(SOCKET s);


/*
 *used for non-blocking connection If you have access to obstructive
 *connection thread waits 75 seconds by default
 *
 *���ڷ�����������,���ȡ�����������ӻ�Ĭ��75����̵߳ȴ�
*/
bool zhSockConnect(SOCKET s,char *szAddr,int port,unsigned long ip);

/*
 *for obstructive connected, according to to set the block timeout
 *
 *����������,���Ը�����Ҫ�趨����ʱ��
*/
bool zhSockBlockingConnect(SOCKET s,char *host,int port, unsigned long ip, int timeout_second);

/*
 *bind port
 *
 *�󶨶˿�
*/
bool zhSockBindAddr(SOCKET s,char *ip,int port);

/*
 *port listen
 *
 *�����˿�
*/
bool zhSockListen(SOCKET s);


/*
 *accept function
 *
 *�ӿں���������
*/
SOCKET zhSockAccept(SOCKET s);

/*
 *send and recv process
 *
 *�������ݷ��ͺͽ��մ���
*/
int zhSockRecv(SOCKET s,char *buf,int len);
int zhSockSend(SOCKET s,char *buf,int len);
int zhSockRecvFrom(SOCKET s,char *buf,int len,struct sockaddr_in *addr,int *addrlen);
int zhSockSendTo(SOCKET s,char *buf,int len,struct sockaddr_in *addr);

/*
 *using select network method to process blocking
 *
 *ʹ��selectģ�ʹ��������ĺ���
*/
bool zhSockCanWrite(SOCKET s,int tv_sec,int tv_usec);
bool zhSockCanRead(SOCKET s,int tv_sec,int tv_usec);
bool zhSockHasExcept(SOCKET s,int tv_sec,int tv_usec);

/*
 *setting blocking configure
 *
 *���ó������������
*/
bool zhSockSetNonBlocking(SOCKET s,bool bSetBlock);
void zhSockReset(SOCKET s);

/*
 *setting socket send and recv cache buffer
 *
 *��������С����
*/
bool zhSockSetSendBufferSize(SOCKET s,int len);
bool zhSockSetRecvBufferSize(SOCKET s,int len);


/*
 *linux/unix using the reset the listen port
 *
 *��linux��unixʹ�����ü����˿ڹ���
*/
bool zhSockSetReuseAddr(SOCKET s,bool reuse);

/*
 *get socket ip and port
 *
 *��ȡsocket��Ӧ��ip�Ͷ˿�
*/
bool zhSockGetLocalAddr (SOCKET s,char *addr,unsigned short *port,unsigned long *ip);
bool zhSockGetRemoteAddr(SOCKET s,char *addr,unsigned short *port,unsigned long *ip);

/*
 *data obtained from addr ip and prot
 *
 *��addr���ȡip��prot������
 */
void zhSockAddrToPram(const struct sockaddr_in *addr,char*ip,unsigned short *port);

/*
 *ip with the port of data stored in addr
 *
 *��ip��port�����ݴ���addr��
 */
void zhSockPramToAddr(const char*ip,unsigned short port,struct sockaddr_in *addr);

/*
 *return network sdk socket count
 *
 *���ر�SOCKET���SOCKETʹ������
*/
int zhSockGetCount();

/*
 *wince and windows using initizal/release socket function
 *
 *windowsϵͳʹ�õĳ�ʼ����ע��socket�Ĺ���
*/
bool zhSock_NetStartUp(int VersionHigh,int VersionLow);
bool zhSock_NetCleanUp();

/*
 *get host to ip 
 *
 *��ȡ����IP
*/
char* zhSockGetIp(char*host);

#ifdef __cplusplus
}
#endif
#endif
