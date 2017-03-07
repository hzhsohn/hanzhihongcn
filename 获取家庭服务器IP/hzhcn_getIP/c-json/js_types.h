#ifndef _JS_TYPES_H_
#define _JS_TYPES_H_

#include "stdio.h"
#include "stdlib.h"
#include "string.h"

#ifdef __cplusplus
extern "C"{
#endif	/*__cplusplus*/

#define FAILED -1
#define SUCCESS 0

#define TRUE	1
#define FALSE	0

#define Js_mem_malloc	malloc
#define Js_mem_free		free
#define Js_memset	memset
#define Js_memcpy	memcpy

#define Js_strcat	strcat
#define Js_strcpy	strcpy
#define Js_strncpy	strncpy
#define Js_strstr	strstr
#define Js_strcmp	strcmp
#define Js_strncmp	strncmp

#define Js_file_open	fopen
#define Js_file_read	fread
#define Js_file_close	fclose

#define Js_atoi	atoi

#define TRACE	printf

typedef unsigned char uint8;
typedef unsigned short uint16;
typedef unsigned int uint32;
typedef signed char int8;
typedef signed short int16;
typedef signed int int32;


#ifdef __cplusplus
}
#endif	/*__cplusplus*/
#endif