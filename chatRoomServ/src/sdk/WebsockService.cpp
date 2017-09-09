#pragma once

#include "stdafx.h"
#include "WebsockService.h"
#include "WebsockNet.h"
#include "websock\websocket.h"
#include <map>

using namespace std;

//�����С
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
//���տͻ��˵���������Ļص�����
void WINAPI WebsockNetAcceptCallBack(HANDLE handle, char *pszIP, WORD wPort);
//�Ͽ��ͻ������ӵĻص�����
void WINAPI WebsockNetDissconnectCallBack(HANDLE handle);
//���յ����ݰ�ʱ�Ļص�����
void WINAPI WebsockNetRecvDataCallBack(HANDLE handle, int nLen, char* pData);

//���տͻ��˵���������Ļص�����
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
//�Ͽ��ͻ������ӵĻص�����
void WINAPI WebsockNetDissconnectCallBack(HANDLE handle)
{	
	EnterCriticalSection(&g_wssCS);
	map<HANDLE,WebsockServiceUser>::iterator it=g_websockUserList.find(handle);
	g_websockUserList.erase(it);
	g_websockServiceDisconnect(handle);
	LeaveCriticalSection(&g_wssCS);
}

//���յ����ݰ�ʱ�Ļص�����
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
			//����0������������
			//����н��ջ�����,�����ֺ�Ҫ�����������
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

			//���Ҫ���ճ��totle��Ҫ�ڻ�������ȥ���ֽ���,����û�д���ճ��
			totle=zhWebSockRecvPack(&pws->hs,pws->recvCache,pws->recvLen,str,&len,&frame_begin,&frame_len);
			if(totle>0)
			{
					g_websockServiceRecv(handle,len,str);
					//printf("������������totle=%d frame_begin=%d frame_len=%d len=%d %s\r\n",totle,frame_begin,frame_len,len,str);
			}
			//ɾ��������������
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