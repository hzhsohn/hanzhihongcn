/*
  platform.h - The difference between the platform and the 
				corresponding processing platform system function
  2009/7/20
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

#ifndef __ZH_NET_PLATFORM_H__
#define __ZH_NET_PLATFORM_H__

/*

boolean does not exist in the C function
在C函数下不存在布尔值类型,所以在此定义

*/
#ifndef __cplusplus
#ifndef bool
#define bool unsigned char
#define true	1
#define false	0
#endif
#endif

#ifdef __cplusplus
extern "C"{
#endif

#include <stdio.h>
#include <stdarg.h>
#include <memory.h>
#include <string.h>
#include <time.h>

#ifdef _WIN32
#pragma warning(disable: 4996)
#pragma warning(disable: 4172)
#endif

#ifdef _WIN32
	#include <windows.h>
	#undef _countof
	#define _countof(array) (sizeof(array)/sizeof(array[0]))
	#define VSNPRINTF(a,b,c,d) _vsnprintf(a,b,c,d)

	/* thread operate*/
	#ifndef _zh_thread_type
		#define CREATE_THREAD(func,arg)		CreateThread(NULL,0,(LPTHREAD_START_ROUTINE)func,(LPVOID)arg,0,NULL)
		#define CREATE_THREAD_RET(ret)		((ret)==0)
		#define _zh_thread_type
	#endif

	#ifndef _zh_cs_type
		#define LOCK_CS(p)					EnterCriticalSection(p)	
		#define UNLOCK_CS(p)				LeaveCriticalSection(p)
		#define INIT_CS(p)					InitializeCriticalSection(p)
		#define DELETE_CS(p)				DeleteCriticalSection(p)					
		#define TYPE_CS						CRITICAL_SECTION 
		#define _zh_cs_type
	#endif

	#define	ZH_INLINE					__inline
#else
	#define LINUX
	#include <sys/time.h>
	#include <stddef.h>
	#include <unistd.h>
	#include <stdlib.h>
	#include <sys/wait.h>

	#define VSNPRINTF(a,b,c,d) vsnprintf(a,b,c,d)
	/* thread operate */
	#include <pthread.h>
	#include <semaphore.h>

	#ifndef _zh_thread_type
		extern pthread_t _pthreadid;
		#define CREATE_THREAD(func,arg)		pthread_create(&_pthreadid,NULL,(void *(*)(void *))func,(void*)arg)
		#define CREATE_THREAD_RET(ret)		((ret)!=0)
		#define _zh_thread_type
	#endif

	#ifndef _zh_cs_type
		#define LOCK_CS(p)					sem_wait(p)
		#define UNLOCK_CS(p)				sem_post(p)
		#define INIT_CS(p)					sem_init(p,0,1)
		#define DELETE_CS(p)				sem_destroy(p)
		#define TYPE_CS						sem_t
	#define _zh_cs_type
	#endif

	#define	ZH_INLINE					inline
#endif


/*
 *data check sum function,the function apply to 
 *zhUdpSendToPack/zhUdpSendTo/zhUdpRecvFrom function
 *
 *数据校检,这函数应用在zhUdpSendToPack/zhUdpSendTo/zhUdpRecvFrom函数里
 */
unsigned short zhPlatCRC16(unsigned char * frame, unsigned short len );


/*
 *function: cross-platform use the sleep function
 *
 *功能:跨平台使用的休眠功能
*/
void zhPlatSleep(int ms);


/*
 *function:Get milliseconds function, linux / unix 
 *after microsecond conversion
 *
 *功能:获取毫秒函数,linux/unix经过微秒转换
*/
time_t zhPlatGetTime();

/*
 *function: Get the system the number of seconds
 *
 *功能:获取系统秒数
*/
time_t zhPlatGetSec();

/*
 *function:WIN32 platform to create and open the console, 
 *as well as the release of the console function
 *
 *功能:在WIN32平台下创建并打开控制台,以及释放控制台函数
*/
void zhPlatCreateConsole();
void zhPlatFreeConsole();


/*
 *function: print global message function
 *
 *功能:打印全局消息函数
*/
void zhPlatPrintf(char*format,...);
void zhPlatPrint16(int len,char*buf);
char* zhPlatPrintf16ToBuf(int len,char *buf,char*dstString);


/*
 *Macro: input information and printing
 *
 *宏:输入信息并打印
*/
#ifndef ZH_NET_DEBUG_PRINTF
#define ZH_NET_DEBUG_PRINTF //zhPlatPrintf
#endif

#define PRINTF zhPlatPrintf

//
//反转字节处理顺序,兼容Big endian 和 Little endian 处理器问题
//
/*
 *Reverse bytes processed sequentially, 
 *compatible with Big endian and Little endian processor issues
 *
 *反转字节处理顺序,兼容Big endian 和 Little endian 处理器问题
*/
static void zhPlatRememory(void *byte,int len) {
    	int i;
    	char memory[sizeof(long)];
		if(len<=sizeof(long)){
    	for(i=0;i<len;i++)memory[i]=((char*)byte)[len-i-1];
		memcpy(byte,memory,len);}
}
#define RE_MEMORY //zhPlatRememory

#ifdef __cplusplus
}
#endif
#endif
