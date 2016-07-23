#include "socket.h"
#include "websocket.h"
#include "main2.h"

//������1000���û�����
#define CLIENT_MAX		1000
SOCKET s,tmps;
SOCKET sary[CLIENT_MAX]={0};//client
BOOL bTcpConnectedAry[CLIENT_MAX]={FALSE};
TzhWebSocket hs[CLIENT_MAX];
char recvCache[CLIENT_MAX][10240]={0};
int recvLen[CLIENT_MAX]={0};

//��������
int online_count=0;

void main2()
{
	main_init2();
	for(;;)
	{
		main_loop2();
		Sleep(1);
	}
	main_destory2();
}
void main_init2()
{	
	zhSockInit(&s,ZH_SOCK_TCP);
	zhSockBindAddr(s,NULL,1000);
	zhSockSetNonBlocking(s,1);
	zhSockListen(s);
	printf("initizal ok...\n");
	printf("bind port=1000\n");
}
void main_destory2()
{	
	int n=0;
	//�ͷ��ڴ�
	for(n=0;n<CLIENT_MAX;n++)
	zhWebSockFree(&hs[n]);
}

void main_loop2()
{
    char recvTmp[102400];
	int nRet,n;
	
	if(tmps=zhSockAccept(s))
	{
		int nnn=0;
		for(nnn=0;nnn<CLIENT_MAX;nnn++)
		{
			if(FALSE==bTcpConnectedAry[nnn])//�Ƿ����ӳɹ���
			{
				sary[nnn]=tmps;
				zhWebSockInit(&hs[nnn]);
				bTcpConnectedAry[nnn]=TRUE;
				online_count++;
				break;
			}
		}
	}
	for(n=0;n<CLIENT_MAX;n++)
	{
		nRet=zhSockRecv(sary[n],recvTmp,sizeof(recvTmp));
			
		if(nRet>0)
		{
			int ret;
			char acceptBuf[1024]={0};
			ret=zhWebSockHandshake(recvTmp,nRet,&hs[n],acceptBuf);
            if(ret==0)
			{
					//����0������������
					//printf("�����¿ͻ���\n");
					zhSockSend(sary[n],acceptBuf,strlen(acceptBuf));	
					//����н��ջ�����,�����ֺ�Ҫ�����������

					////////////////////////////
					{
						int a;
						char str[1000];
						//ѭ�����͸����пͻ���
						for(a=0;a<CLIENT_MAX;a++)
							if(TRUE==bTcpConnectedAry[a])//�Ƿ����ӳɹ���
							{
								if(n==a)
								{
									//�������û���Ϣ
									sprintf(str,"{\"cmd\":0,\"online_count\":%d}",online_count);
									zhWebSockSendData(&hs[a],str,strlen(str),recvTmp,&nRet);
									zhSockSend(sary[a],recvTmp,nRet);
								}
								else
								{
									//���;��û�������һ������
									char str[1000];
									sprintf(str,"{\"cmd\":1,\"online_count\":%d}",online_count);
									zhWebSockSendData(&hs[a],str,strlen(str),recvTmp,&nRet);
									zhSockSend(sary[a],recvTmp,nRet);
								}
							}
					}
					////////////////////////////////
			}
			else if(ret==1)
			{
					int a;
					int totle,frame_begin,frame_len;
					char str[2048]={0}; 
					int len;
				
					//���ݻ���
					memcpy(&recvCache[n][recvLen[n]],recvTmp,nRet);
					recvLen[n]+=nRet;

					//���Ҫ���ճ��totle��Ҫ�ڻ�������ȥ���ֽ���,����û�д���ճ��
					totle=zhWebSockRecvPack(&hs[n],recvCache[n],recvLen[n],str,&len,&frame_begin,&frame_len);
					if(totle>0)
					{
							//ѭ�����͸����пͻ���
							for(a=0;a<CLIENT_MAX;a++)
							{
								if(TRUE==bTcpConnectedAry[a])//�Ƿ����ӳɹ���
								{
									zhWebSockSendData(&hs[a],str,len,recvTmp,&nRet);
									zhSockSend(sary[a],recvTmp,nRet);
								}
							}		
						//printf("������������totle=%d frame_begin=%d frame_len=%d len=%d %s\r\n",totle,frame_begin,frame_len,len,str);
					}
					//ɾ��������������
					recvLen[n]-=totle;
					memcpy(&recvCache[n][0],&recvCache[n][totle],recvLen[n]);
			}
		}
		else if(nRet==-1)
		{
			//disconnect
			if(TRUE==bTcpConnectedAry[n])
			{
				bTcpConnectedAry[n]=FALSE;
				online_count--;
				//printf("�Ͽ�һ���ͻ���\n");
				/////////////////////////
				{
						//����������.��������
						int a;
						char str[1000];
						for(a=0;a<CLIENT_MAX;a++)
						if(TRUE==bTcpConnectedAry[a])//�Ƿ����ӳɹ���
						{
								
								//���;��û����˸���
								sprintf(str,"{\"cmd\":2,\"online_count\":%d}",online_count);
								zhWebSockSendData(&hs[a],str,strlen(str),recvTmp,&nRet);
								zhSockSend(sary[a],recvTmp,nRet);
						}
				}
				//////////////////////////////
			}
		}
	}
}
