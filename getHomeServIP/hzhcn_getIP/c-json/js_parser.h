#ifndef _JS_PARSER_H_
#define _JS_PARSER_H_

#include "js_types.h"

#ifdef __cplusplus
extern "C"{
#endif

//json对象结构体
typedef struct jsonObjectStruct
{
	//对象解析状态
	int8 obj_state;
	//对象数据指针
	void *obj_data;
}JOBJECT, *PJOBJECT;

//json元素结构体
typedef struct jsonMemberStruct
{
	//元素解析状态
	int8 mem_state;
	//元素键名指针
	void *mem_key;
	//元素键值指针
	void *mem_value;
	//下一节点指针
	struct jsonMemberStruct *mem_next;
}JMEMBER, *PJMEMBER;

//json键名结构体
typedef struct jsonKeyStruct
{
	//键名解析状态
	int8 key_state;
	//键名数据类型
	int8 key_type;
	//键名数据指针
	void *key_data;
}JKEY, *PJKEY;

//json键值结构体
typedef struct jsonValueStruct
{
	//键值解析状态
	int8 value_state;
	//键值数据类型
	int8 value_type;
	//键值数据指针
	void *value_data;
}JVALUE, *PJVALUE;

//json数组结构体
typedef struct jsonArrayStruct
{
	//数组解析状态
	int8 array_state;
	//数组数据指针
	void *array_data;
	//下一节点指针
	struct jsonArrayStruct *array_next;
}JARRAY, *PJARRAY;

//json字符结构体
typedef struct jsonStringStruct
{
	//字符串解析状态
	int8 str_state;
	//字符串指针
	char *str_data;
	//字符串长度
	int32 str_len;
}JSTRING, *PJSTRING;


//json数据结构体
typedef struct jsonDataStruct
{
	//数据解析状态
	int8 data_state;
	//数据指针
	char *data_data;
	//数据长度
	int32 data_len;
}JDATA, *PJDATA;

//数据类型
enum JS_DATA_TYPE
{
	JS_STRING,						//字符串
	JS_DATA,						//数据
	JS_ARRAY,						//数组
	JS_OBJECT,						//对象
};

//键值键名标记
enum JS_DATA_FLAG
{
	JS_PARSER_KEY,					//键名
	JS_PARSER_VALUE,				//键值
};

//解析状态
enum JS_PARSER_OBJ_STATE
{
	JS_PARSER_OBJ_START,			//开始解析json对象
	JS_PARSER_OBJ_END,				//完成解析json对象
	JS_PARSER_OBJ_ERR,				//解析json对象异常
};

enum JS_PARSER_MEM_STATE
{
	JS_PARSER_MEM_START,			//开始解析json元素
	JS_PARSER_MEM_END,				//完成解析json元素
	JS_PARSER_MEM_ERR,				//解析json元素异常
};

enum JS_PARSER_KEY_STATE
{
	JS_PARSER_KEY_START,			//开始解析json键名
	JS_PARSER_KEY_END,				//完成解析json键名
	JS_PARSER_KEY_ERR,				//解析json键名异常
};

enum JS_PARSER_VAL_STATE
{
	JS_PARSER_VAL_START,			//开始解析json键值
	JS_PARSER_VAL_END,				//完成解析json键值
	JS_PARSER_VAL_ERR,				//解析json键值异常
};

enum JS_PARSER_ARR_STATE
{
	JS_PARSER_ARR_START,			//开始解析json数组
	JS_PARSER_ARR_END,				//完成解析json数组
	JS_PARSER_ARR_ERR,				//解析json数组异常
};

enum JS_PARSER_STR_STATE
{
	JS_PARSER_STR_START,			//开始解析json字符串
	JS_PARSER_STR_CONTINUE,			//继续解析json字符串
	JS_PARSER_STR_END,				//完成解析json字符串
	JS_PARSER_STR_ERR,				//解析json字符串异常
};

enum JS_PARSER_DATA_STATE
{
	JS_PARSER_DATA_START,			//开始解析json数据
	JS_PARSER_DATA_END,				//完成解析json数据
	JS_PARSER_DATA_ERR,				//解析json数据异常
};

//返回状态
#define JS_RET_SUCCESS		0
#define JS_RET_FAILED		-1
#define JS_RET_EXECUTE		1


/* 解析json对象
 * param parent_data: 父节点数据指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_object(void **parent_data,  char *buffer, int *index);

/* json对象解析状态机
 * param object: 对象节点指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_object_state(PJOBJECT object,  char *buffer, int *index);

/* 解析json元素
 * param parent_data: 父节点数据指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_member(void **parent_data, char *buffer, int *index);

/* json元素解析状态机
 * param member: 元素节点指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_member_state(PJMEMBER member, char *buffer, int *index);

/* 解析json键名
 * param parent_data: 父节点数据指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_key(void **parent_data,  char *buffer, int *index);

/* json键名解析状态机
 * param key: 键名节点指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_key_state(PJKEY key, char *buffer, int *index);

/* 解析json键值
 * param parent_data: 父节点数据指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_value(void **parent_data, char *buffer, int *index);

/* json键值解析状态机
 * param value: 键值节点指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_value_state(PJVALUE value, char *buffer, int *index);

/* 解析json数组
 * param parent_data: 父节点数据指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_array(void **parent_data, char *buffer, int *index);

/* json数组解析状态机
 * param array: 数组节点指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_array_state(PJARRAY array, char *buffer, int *index);

/* 解析json字符串
 * param parent_data: 父节点数据指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_string(void **parent_data, char *buffer, int *index);

/* json字符串解析状态机
 * param string: 字符串节点指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_string_state(PJSTRING string, char *buffer, int *index);

/* 解析json数据
 * param parent_data: 父节点数据指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_data(void **parent_data, char *buffer, int *index);

/* json数据解析状态机
 * param data: 数据节点指针
 * param buffer: 字符缓冲区
 * param index: 当前字符index值
 * ret: 参照（JS_RET_STATE）
 */
int Js_parser_data_state(PJDATA data, char *buffer, int *index);

/* 释放json对象
 * param object: 对象指针
 */
void Js_parser_object_free(PJOBJECT object);

/* 释放json元素
 * param member: 元素指针
 */
void Js_parser_member_free(PJMEMBER member);

/* 释放json键名
 * param key: 键名指针
 */
void Js_parser_key_free(PJKEY key);

/* 释放json键值
 * param value: 键值指针
 */
void Js_parser_value_free(PJVALUE value);

/* 释放json数组
 * param array: 数组指针
 */
void Js_parser_array_free(PJARRAY array);

/* 释放json字符串
 * param string: 字符串指针
 */
void Js_parser_string_free(PJSTRING string);

/* 释放json数据
 * param data: 数据指针
 */
void Js_parser_data_free(PJDATA data);

/* 获取json数据
 * param object: 对象指针
 * param key: 键名名称
 * ret:键值结构指针
 */
void *Js_object_get_value(PJOBJECT object, char *key);

/* 获取json数据
 * param member: 元素指针
 * param key: 键名名称
 * ret:键值结构指针
 */
void *Js_member_get_value(PJMEMBER member, char *key);

/* 判断键名是否相等
 * param key: 键名指针
 * param key_name: 键名名称
 * ret: TRUE(相等), FALSE(不等)
 */
int Js_key_is_equal(PJKEY key, char *key_name);

/* 从数组里获取数据
 * param array: 数组指针
 * param index: 索引值
 * ret: 键值结构指针
 */
void *Js_array_get_value(PJARRAY array, int index);

/* 获取数组大小
 * param array: 数组指针
 * ret: 数组大小
 */
int Js_array_get_count(PJARRAY array);

#ifdef __cplusplus
}
#endif

#endif