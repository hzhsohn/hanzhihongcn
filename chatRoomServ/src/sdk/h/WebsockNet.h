#pragma once

#include <wtypes.h>

//����API����ʱʹ������ĺ궨��
#ifndef DLLEXPORT_API
	#define DLLEXPORT_API extern "C" __declspec(dllexport) 
#endif
//������ʱʹ������ĺ궨��
#ifndef DLLEXPORT_CLASS
	#define DLLEXPORT_CLASS __declspec(dllexport) 
#endif

//������ʱʹ������ĺ궨��
#ifndef DLLEXPORT_MULT
#define DLLEXPORT_MULT __declspec(dllexport) 
#endif

typedef void(WINAPI* IOCPNET_ACCEPT_CALLBACK)(HANDLE handle, char* pszIP, WORD wPort);
typedef void (WINAPI* IOCPNET_RECV_DATA_CALLBACK)(HANDLE handle, int nLen, char* pData);
typedef void (WINAPI* IOCPNET_DISCONNECT_CALLBACK)(HANDLE handle);

DLLEXPORT_API VOID WINAPI IocpNetBegin();
DLLEXPORT_API VOID WINAPI IocpNetEnd();

DLLEXPORT_API BOOL WINAPI IocpNetInit(IOCPNET_RECV_DATA_CALLBACK pfnRecvDataCallback,
											IOCPNET_DISCONNECT_CALLBACK pfnDisconnectCallback, 
											IOCPNET_ACCEPT_CALLBACK pfnAcceptCallback, 
											WORD wPort=0);
DLLEXPORT_API BOOL WINAPI IocpNetSend(HANDLE handle, int nLen, char* pData);

DLLEXPORT_API char* WINAPI IocpNetGetIp(char*host,char*ip);//������ȡIP
DLLEXPORT_API HANDLE WINAPI IocpNetConnect(char* pszIP, WORD wPort, int nTimeOut=5000);//Ĭ��5��
DLLEXPORT_API BOOL WINAPI IocpNetDisconnect(HANDLE handle=NULL);


DLLEXPORT_API char* WINAPI IocpNetGetPeerIP(HANDLE handle, char* pszIp);
DLLEXPORT_API WORD WINAPI IocpNetGetPeerPort(HANDLE handle);
