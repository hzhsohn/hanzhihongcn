// TestGCSRTNet.cpp : �������̨Ӧ�ó������ڵ㡣
//

#include "stdafx.h"
#include "time.h"
#include "WebsockService.h"
#include <vector>
using namespace std;

vector<string> listBuf; //�������¼
vector<HANDLE> lstUser;

//���տͻ��˵���������Ļص�����
void WINAPI AcceptCallBack(HANDLE handle, char* pszIP, WORD wPort);
//�Ͽ��ͻ������ӵĻص�����s
void WINAPI DissconnectCallBack(HANDLE handle);
//���յ����ݰ�ʱ�Ļص�����
void WINAPI RecvDataCallBack(HANDLE handle, int nLen, char* pData);

//���տͻ��˵���������Ļص�����
void WINAPI AcceptCallBack(HANDLE handle, char *pszIP, WORD wPort)
{
	_tprintf(_T("AcceptCallBack-->handle=%p, pszIP=%s, wPort=%04d \n"), handle, pszIP, wPort);	

	char str[1000]={0};

	//�������û���Ϣ
	sprintf(str,"{\"cmd\":0,\"online_count\":%d}",lstUser.size()+1);
	WebsockServiceSend(handle, str);

	for(int i=0;i<listBuf.size();i++)
	{
		sprintf(str,"%s",listBuf[i].c_str());
		WebsockServiceSend(handle, str);
	}
	//���;��û�������һ������
	for(int i=0;i<lstUser.size();i++)
	{		
		sprintf(str,"{\"cmd\":1,\"online_count\":%d}",lstUser.size()+1);
		WebsockServiceSend(lstUser[i], str);
	}
	lstUser.push_back(handle);
}
//�Ͽ��ͻ������ӵĻص�����
void WINAPI DissconnectCallBack(HANDLE handle)
{	
	//ֱ���˳�,�����������
	_tprintf(_T("DissconnectCallBack-->handle=%p\n"), handle);

	char str[1000]={0};
	int onlineCount=lstUser.size()-1;
	vector<HANDLE>::iterator it;
	for(it=lstUser.begin();it!=lstUser.end();)
	{
		if(*it==handle)
		{
			it=lstUser.erase(it);
		}
		else
		{
			sprintf(str,"{\"cmd\":2,\"online_count\":%d}",onlineCount);
			WebsockServiceSend(*it, str);
			it++;
		}
	}
}

//���յ����ݰ�ʱ�Ļص�����
void WINAPI RecvDataCallBack(HANDLE handle, int nLen, char* pData)
{
	char ip[32];
	WebsockServiceGetPeerIP(handle,ip);

	pData[nLen]=0;
	_tprintf(_T("Recv Socket=%p  ip=%s , nLen=%d, %s , time=%d\n\n"),handle,ip, nLen,pData,time(NULL));

	//�����������¼
	if(listBuf.size()>=10)
	{
		listBuf.erase(listBuf.begin());
	}
	listBuf.push_back(pData);

	vector<HANDLE>::iterator it;
	for(it=lstUser.begin();it!=lstUser.end();it++)
	{
		//���ص��ͻ���
		WebsockServiceSend(*it,pData);
	}
}

int _tmain(int argc, _TCHAR* argv[])
{
	_tprintf(_T("The websocket is server.\n"));
	if(!WebsockServiceInit(AcceptCallBack,RecvDataCallBack,DissconnectCallBack, 1000))
	{
		_tprintf(_T("WebsockNetInit failed as server.\n"));
		getchar();
		return 0;
	}

	int nExitCode;
	while(true)
	{
		scanf( "%d", &nExitCode);
		if(nExitCode == 0)
		{
			break;
		}
	}

	WebsockServiceDestory();

	return 0;
}