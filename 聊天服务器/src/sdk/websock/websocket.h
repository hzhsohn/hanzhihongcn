#ifndef _WEBSOCKET_HANDSHAKE_H_
#define _WEBSOCKET_HANDSHAKE_H_

#ifdef __cplusplus
extern "C"{
#endif

#include<string.h>
#include<stdlib.h>

#ifndef _WIN32
	#ifndef strcmpi
	#define strcmpi     strcasecmp
	#endif 
#else
	#ifndef strtok_r
	#define strtok_r    strtok_s
	#endif 
#endif

typedef enum _EzhWebSocketMethod
{
	WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW,
	WEB_SOCKET_HANDSHAKE_METHOD_1,  //safari
	WEB_SOCKET_HANDSHAKE_METHOD_2	//chrome,firefox
}EzhWebSocketMethod;

typedef struct _TzhWebSocket 
{
	EzhWebSocketMethod method;
	char *resource;
	char *host;
	char *origin;
	char *protocol;
	char *key;
	char *key1;
	char *key2;
	char *version;
}TzhWebSocket;

//ȥ���ҿո�
char *zhWebSockLTrim( char *str);
//ȥ����ո� 
char *zhWebSockRTrim( char *str);
//ȥ�����߿ո�
char *zhWebSockTrim(char *str);

//�����ַ���������
char* zhWebSockMatchString(const char* src, const char* pattern, char end);

//���ְ�����---------------------BEGIN------------------

//����Э�� safari
//=0 �ɹ�
//=1 ʧ��

int zhWebSockHandshake_1(const char* src,TzhWebSocket* hs,char* acceptBuf);
//����Э�� chrome firefox ie10
//=0 �ɹ�
//=1 ʧ��
int zhWebSockHandshake_2(const char* src,TzhWebSocket* hs,char* acceptBuf);
//���ְ�����-----------------------END----------------

//��ȡ������---------------------BEGIN------------------

//safari ��ʼ����β  0x00-0xff
int zhWebSockPackMethod_1(const unsigned char* cache,int cache_len,unsigned char* packet,int* nPacket);

/*chrome firefox ie10��Э�� 
0x81��ͷ 
�ڶ����ֽ� (cache[1] & 0x80) == 0x80 ,Ϊ���ݱ�ʶ
�ڶ����ֽ� nCode=cache[1]&0x7f ,��126,127,��ͨ,����
���ݵڶ����ֽ�nCodeȷ��,�ڼ�λ��ʼ�����ݼ���Կ��,ռ4���ֽ�
*/
int zhWebSockPackMethod_2(const unsigned char* cache,int cache_len,unsigned char* packet,int* nPacket);
//��ȡ������---------------------END------------------

/*
   Э�����  �ϰ汾�����°汾
   return 
       1Ϊ�°汾 
	   2Ϊ�ϰ汾 
	   0��Э��
   src
       Ҫ����������
*/
EzhWebSocketMethod zhWebSockIdentify(const char* buf,int buflen);


///////////////////////////////////////////////////////////////////////
//�ⲿ����
//��ʼ������
int zhWebSockInit(TzhWebSocket* hs);

//��ȡ�ж�
//��ȷ��ȡWEBSOCKETͷ��Ϣ����0��acceptBufΪsocketҪ���ص�SOCKET��Ϣ,���󷵻�-1 ,�Ѿ����ֳɹ�����1
int zhWebSockHandshake(const char* recvbuf,int buflen,TzhWebSocket* hs,char* acceptBuf);

//�ͷ�������Ϣ
void zhWebSockFree(TzhWebSocket* hs);

//����
void zhWebSockSendData(const TzhWebSocket* hs,const char*sendBuf,int sendLen,char* sendData,int* dataLen);

/*
�����������������������ݰ����ܳ���,���������ǲ��������߲�ƥ��
char* packet ��ȡ�����������ֽ�
int* nPacket �������ݵĳ��� 
int*frame_begin_pos �ڻ����еĿ�ʼ�ֽ�,������ͬ�汾��websocket������֡��ʶ
int*frame_len  ������ͬ�汾��websocket������֡�ĳ���
����
 =0 ����
 >0 ��������֡���ֽ���,Ҳ���ڻ�������Ҫɾ�����ֽ�
*/
int zhWebSockRecvPack(const TzhWebSocket* hs,const char* cache,int cache_len,char* packet,int* packet_len,int*frame_begin_pos,int*frame_len);


#ifdef __cplusplus
}
#endif

#endif