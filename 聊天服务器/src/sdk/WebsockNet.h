#pragma once

#include <wtypes.h>

typedef void(WINAPI* WEBSOCK_ACCEPT_CALLBACK)(HANDLE handle, char* pszIP, WORD wPort);
typedef void (WINAPI* WEBSOCK_RECV_DATA_CALLBACK)(HANDLE handle, int nLen, char* pData);
typedef void (WINAPI* WEBSOCK_DISCONNECT_CALLBACK)(HANDLE handle);

VOID WebsockNetBegin();
VOID WebsockNetEnd();

BOOL WebsockNetInit(WEBSOCK_RECV_DATA_CALLBACK pfnRecvDataCallback,
											WEBSOCK_DISCONNECT_CALLBACK pfnDisconnectCallback, 
											WEBSOCK_ACCEPT_CALLBACK pfnAcceptCallback, 
											WORD wPort=0);
BOOL WebsockNetSend(HANDLE handle, int nLen, char* pData);

BOOL WebsockNetDisconnect(HANDLE handle);

char* WebsockNetGetPeerIP(HANDLE handle, char* pszIp);
WORD WebsockNetGetPeerPort(HANDLE handle);
