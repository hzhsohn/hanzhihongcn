#pragma once

#include "stdafx.h"
#include "WebsockService.h"
#include "WebsockNet.h"
#include "websock\websocket.h"
#include <map>

using namespace std;

//缓冲大小
#define WEBSOCK_CHCHE_SIZE	10240
struct WebsockServiceUser
{
	HANDLE handle;
	TzhWebSocket hs;
	char recvCache[WEBSOCK_CHCHE_SIZE];
	int recvLen;
	char ip[46];
	int port;
	
	WebsockServiceUser()
	{
		handle=NULL;
		zhWebSockInit(&hs);
		memset(recvCache,0,10240);
		recvLen=0;
	}
};

//---------------------------------------
WEBSOCK_SERVICE_ACCEPT_CALLBACK g_websockServiceAccept;
WEBSOCK_SERVICE_RECV_CALLBACK g_websockServiceRecv;
WEBSOCK_SERVICE_DISCONNECT_CALLBACK g_websockServiceDisconnect;

//---------------------------------------
CRITICAL_SECTION g_wssCS;
map<HANDLE,WebsockServiceUser> g_websockUserList;

//---------------------------------------
//接收客户端的连接请求的回调函数
void WINAPI WebsockNetAcceptCallBack(HANDLE handle, char *pszIP, WORD wPort);
//断开客户端连接的回调函数
void WINAPI WebsockNetDissconnectCallBack(HANDLE handle);
//接收到数据包时的回调函数
void WINAPI WebsockNetRecvDataCallBack(HANDLE handle, int nLen, char* pData);

//接收客户端的连接请求的回调函数
void WINAPI WebsockNetAcceptCallBack(HANDLE handle, char *pszIP, WORD wPort)
{
	if(strlen(pszIP)>0)
	{
		EnterCriticalSection(&g_wssCS);

		WebsockServiceUser tmp;
		tmp.handle=handle;
		strcpy_s(tmp.ip,pszIP);
		tmp.port=wPort;
		g_websockUserList.insert(make_pair(handle,tmp));

		LeaveCriticalSection(&g_wssCS);
	}
}
//断开客户端连接的回调函数
void WINAPI WebsockNetDissconnectCallBack(HANDLE handle)
{	
	EnterCriticalSection(&g_wssCS);
	map<HANDLE,WebsockServiceUser>::iterator it=g_websockUserList.find(handle);
	g_websockUserList.erase(it);
	g_websockServiceDisconnect(handle);
	LeaveCriticalSection(&g_wssCS);
}

//接收到数据包时的回调函数
void WINAPI WebsockNetRecvDataCallBack(HANDLE handle, int nLen, char* pData)
{
	EnterCriticalSection(&g_wssCS);
	int ret;
	char acceptBuf[512]={0};

	map<HANDLE,WebsockServiceUser>::iterator it=g_websockUserList.find(handle);
	WebsockServiceUser* pws=&it->second;

	memcpy(&pws->recvCache[pws->recvLen],pData,nLen);
	pws->recvLen+=nLen;

	ret=zhWebSockHandshake(pws->recvCache,pws->recvLen,&pws->hs,acceptBuf);
    if(ret==0)
	{
			//等于0就是握手数据
			//如果有接收缓冲区,在握手后要清空所有内容
			WebsockNetSend(handle, strlen(acceptBuf),acceptBuf);
			////////////////////////////
			g_websockServiceAccept(handle, pws->ip, pws->port);
			////////////////////////////////
			pws->recvLen=0;
			memset(&pws->recvCache,0,WEBSOCK_CHCHE_SIZE);
	}
	else if(ret==1)
	{
			int totle,frame_begin,frame_len;
			char str[2048]={0}; 
			int len;

			//如果要解决粘包totle是要在缓冲区减去的字节数,这里没有处理粘包
			totle=zhWebSockRecvPack(&pws->hs,pws->recvCache,pws->recvLen,str,&len,&frame_begin,&frame_len);
			if(totle>0)
			{
					g_websockServiceRecv(handle,len,str);
					//printf("传输数据来了totle=%d frame_begin=%d frame_len=%d len=%d %s\r\n",totle,frame_begin,frame_len,len,str);
			}
			//删除处理过后的数据
			pws->recvLen-=totle;
			memcpy_s(&pws->recvCache[0],WEBSOCK_CHCHE_SIZE,&pws->recvCache[totle],pws->recvLen);
	}
	LeaveCriticalSection(&g_wssCS);
}

DLLEXPORT_API BOOL WINAPI WebsockServiceInit(WEBSOCK_SERVICE_ACCEPT_CALLBACK pfnAcceptCallback, 
											 WEBSOCK_SERVICE_RECV_CALLBACK pfnRecvDataCallback,
											 WEBSOCK_SERVICE_DISCONNECT_CALLBACK pfnDisconnectCallback, 
											WORD wPort)
{
	InitializeCriticalSection(&g_wssCS);

	g_websockServiceAccept=pfnAcceptCallback;
	g_websockServiceRecv=pfnRecvDataCallback;
	g_websockServiceDisconnect=pfnDisconnectCallback;
	WebsockNetBegin();
	return WebsockNetInit(WebsockNetRecvDataCallBack,WebsockNetDissconnectCallBack,WebsockNetAcceptCallBack,wPort);
}

DLLEXPORT_API VOID WINAPI WebsockServiceDestory()
{
	DeleteCriticalSection(&g_wssCS);

	g_websockServiceAccept=NULL;
	g_websockServiceRecv=NULL;
	g_websockServiceDisconnect=NULL;
	WebsockNetEnd();
}

DLLEXPORT_API BOOL WINAPI WebsockServiceSend(HANDLE handle,char* sendBuf)
{
	map<HANDLE,WebsockServiceUser>::iterator it=g_websockUserList.find(handle);
	char *sendData;
	int sendLen;
	int tmpLen=strlen(sendBuf);
	sendData=(char*)malloc(tmpLen+32);
	WebsockServiceUser* pws=&it->second;
	zhWebSockSendData(&pws->hs,sendBuf,tmpLen,sendData,&sendLen);
	return WebsockNetSend(handle,  sendLen, sendData);
}   

DLLEXPORT_API BOOL WINAPI WebsockServiceDisconnect(HANDLE handle)
{
	return WebsockNetDisconnect(handle);
}

DLLEXPORT_API char* WINAPI WebsockServiceGetPeerIP(HANDLE handle, char* pszIp)
{
	return WebsockNetGetPeerIP(handle,pszIp);
}

DLLEXPORT_API WORD WINAPI WebsockServiceGetPeerPort(HANDLE handle)
{
	return WebsockNetGetPeerPort(handle);
}