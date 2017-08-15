#include "stdafx.h"

#include <MSTcpIP.h>
#include "WebsockSockMgr.h"
#include "WebsockDealQueMgr.h"
#include "WebsockNet.h"

WEBSOCK_RECV_DATA_CALLBACK		g_pfWebsockNetReceiveData_cb=NULL;
WEBSOCK_DISCONNECT_CALLBACK		g_pfWebsockNetDisconnect_cb=NULL;
WEBSOCK_ACCEPT_CALLBACK			g_pfWebsockNetAccept_cb=NULL;

HANDLE g_hThreadHandle[1024];			//�����߳̾���������ڳ������ʱ���ر��߳�
int g_nIocpNETThreadHandleCnt = 0;		//�߳���

WebsockSockMgr* g_pSockMgr=NULL;
int g_nIocpNetWorkThreadCnt = 1;		//�����߳�������һ�������̶߳�Ӧһ��WebsockSockMgr��һ����ɶ˿ھ��
bool g_bIocpNetGCThreadRun;

BOOL GCEApiSRTNetDestroy();

WebsockSockMgr*  GetSocketMgr(HANDLE handle)
{
	GCSTS_Sock_Info* p = (GCSTS_Sock_Info*)handle;
	int i;
	for(i=0; i<g_nIocpNetWorkThreadCnt; i++)
	{
		if(g_pSockMgr[i].IsExist(p))
			return &g_pSockMgr[i];
	}
	return NULL;
}

void  DeleteAllSocketMgr()
{
	int i;
	for(i=0; i<g_nIocpNetWorkThreadCnt; i++)
	{
		g_pSockMgr[i].DisconnectAll();
	}
}

void DestroySocketMgr()
{
	if(g_pSockMgr == NULL)
		return;
	int i;
	for(i=0; i<g_nIocpNetWorkThreadCnt; i++)
	{
		if(g_pSockMgr)
		g_pSockMgr[i].Destroy();
	}
	delete []g_pSockMgr;
	g_pSockMgr = NULL;
}

VOID WebsockNetBegin()
{
		g_nIocpNETThreadHandleCnt = 0;
		g_nIocpNetWorkThreadCnt = 1;
		g_bIocpNetGCThreadRun=true;
		WebsockDealQueMgr::Init();
		WebsockCore::Init();
}
VOID WebsockNetEnd()
{
		DeleteAllSocketMgr();
		GCEApiSRTNetDestroy();
		g_bIocpNetGCThreadRun=false;
		WebsockDealQueMgr::Destroy();
		WebsockCore::Destroy();
		
		//������DeleteAllSocketMgr();GCEApiSRTNetDestroy();
		//��������Ӽ�������ڷ������رյ�ʱ������
		DestroySocketMgr();
}
/////////////////////////////////////////////////////////////////////////
//�����Ƿ������ˣ����ǿͻ��˶����������ʼ������
BOOL WebsockNetInit(WEBSOCK_RECV_DATA_CALLBACK pfnRecvDataCallback,
										   WEBSOCK_DISCONNECT_CALLBACK pfnDisconnectCallback, 
										   WEBSOCK_ACCEPT_CALLBACK pfnAcceptCallback, 
										   WORD wPort)
{
	if(pfnRecvDataCallback == NULL || pfnDisconnectCallback==NULL || pfnAcceptCallback == NULL)
	{
		//GCH_ETRACE(_T("WebsockNetInit pfnRecvDataCallback == NULL || pfnDisconnectCallback==NULL || pfnAcceptCallback == NULL."));
		return FALSE;
	}
	g_pfWebsockNetReceiveData_cb = pfnRecvDataCallback;
	g_pfWebsockNetDisconnect_cb = pfnDisconnectCallback;
	g_pfWebsockNetAccept_cb = pfnAcceptCallback;

	DWORD dwThreadId = 0;
	HANDLE hThread = NULL;

	if(!WebsockCore::InitNet(wPort))
	{
		//GCH_ETRACE(_T("WebsockNetInit WebsockCore::Init failed.port=%d"), wPort);
		return FALSE;
	}

	//���㹤���߳���
	SYSTEM_INFO systemInfo;
	GetSystemInfo(&systemInfo);
	g_nIocpNetWorkThreadCnt = systemInfo.dwNumberOfProcessors * 2 + 2;
	g_pSockMgr = new WebsockSockMgr[g_nIocpNetWorkThreadCnt];
	
	int i;
	for(i=0; i<g_nIocpNetWorkThreadCnt; i++)
	{
		g_pSockMgr[i].Init(WebsockCore::m_hRecvEvent);
	}

	//3.�������մ����߳�
	hThread = CreateThread(NULL, 0, WebsockCore::DealRecvDataThread, NULL, 0, &dwThreadId);
	if(hThread==NULL)
	{
		//GCH_ETRACE(_T("WebsockNetInit CreateThread WebsockCore::DealRecvDataThread failed."));
		return FALSE;
	}
	g_hThreadHandle[g_nIocpNETThreadHandleCnt++] = hThread;

	//4.���������������߳�
	if(pfnAcceptCallback != NULL && wPort != 0)
	{
		hThread = CreateThread(NULL, 0, WebsockCore::AcceptThread, &wPort, 0, &dwThreadId);
		if(hThread==NULL)
		{
			//GCH_ETRACE(_T("WebsockNetInit CreateThread WebsockCore::AcceptThread failed."));
			return FALSE;
		}
		g_hThreadHandle[g_nIocpNETThreadHandleCnt++] = hThread;
	}

	Sleep(100);

	return TRUE;
}
BOOL GCEApiSRTNetDestroy()
{
	int i;

	for(i=0; i<g_nIocpNETThreadHandleCnt; i++)
	{
		TerminateThread(g_hThreadHandle[i], -1);
		CloseHandle(g_hThreadHandle[i]);
		//GCH_MTRACE(_T("GCEApiSRTNetDestroy g_hThreadHandle[%d]=%d."), i, g_hThreadHandle[i]);
	}
	g_nIocpNETThreadHandleCnt=0;
	WebsockCore::Destroy();
	return TRUE;
}

BOOL WebsockNetDisconnect(HANDLE handle)
{
	WebsockSockMgr* pSockMgr = GetSocketMgr(handle);
	if(pSockMgr == NULL)
		return FALSE;

	pSockMgr->DeleteSock(handle);

	return TRUE;
}


BOOL WebsockNetSend(HANDLE handle, int nLen, char* pData)
{
	WebsockSockMgr* pSockMgr = GetSocketMgr(handle);
	if(pSockMgr == NULL)
		return FALSE;

	return pSockMgr->SendPacket(handle, nLen, pData);
}

char* WebsockNetGetPeerIP(HANDLE handle, char* pszIp)
{
	WebsockSockMgr* pSockMgr = GetSocketMgr(handle);
	if(pSockMgr == NULL)
		return NULL;

	return pSockMgr->GetPeerIP(handle, pszIp);
}

WORD WebsockNetGetPeerPort(HANDLE handle)
{
	WebsockSockMgr* pSockMgr = GetSocketMgr(handle);
	if(pSockMgr == NULL)
		return 0;

	return pSockMgr->GetPeerPort(handle);
}
