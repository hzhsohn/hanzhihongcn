#ifndef _JS_PARSER_H_
#define _JS_PARSER_H_

#include "js_types.h"

#ifdef __cplusplus
extern "C"{
#endif

//json����ṹ��
typedef struct jsonObjectStruct
{
	//�������״̬
	int8 obj_state;
	//��������ָ��
	void *obj_data;
}JOBJECT, *PJOBJECT;

//jsonԪ�ؽṹ��
typedef struct jsonMemberStruct
{
	//Ԫ�ؽ���״̬
	int8 mem_state;
	//Ԫ�ؼ���ָ��
	void *mem_key;
	//Ԫ�ؼ�ֵָ��
	void *mem_value;
	//��һ�ڵ�ָ��
	struct jsonMemberStruct *mem_next;
}JMEMBER, *PJMEMBER;

//json�����ṹ��
typedef struct jsonKeyStruct
{
	//��������״̬
	int8 key_state;
	//������������
	int8 key_type;
	//��������ָ��
	void *key_data;
}JKEY, *PJKEY;

//json��ֵ�ṹ��
typedef struct jsonValueStruct
{
	//��ֵ����״̬
	int8 value_state;
	//��ֵ��������
	int8 value_type;
	//��ֵ����ָ��
	void *value_data;
}JVALUE, *PJVALUE;

//json����ṹ��
typedef struct jsonArrayStruct
{
	//�������״̬
	int8 array_state;
	//��������ָ��
	void *array_data;
	//��һ�ڵ�ָ��
	struct jsonArrayStruct *array_next;
}JARRAY, *PJARRAY;

//json�ַ��ṹ��
typedef struct jsonStringStruct
{
	//�ַ�������״̬
	int8 str_state;
	//�ַ���ָ��
	char *str_data;
	//�ַ�������
	int32 str_len;
}JSTRING, *PJSTRING;


//json���ݽṹ��
typedef struct jsonDataStruct
{
	//���ݽ���״̬
	int8 data_state;
	//����ָ��
	char *data_data;
	//���ݳ���
	int32 data_len;
}JDATA, *PJDATA;

//��������
enum JS_DATA_TYPE
{
	JS_STRING,						//�ַ���
	JS_DATA,						//����
	JS_ARRAY,						//����
	JS_OBJECT,						//����
};

//��ֵ�������
enum JS_DATA_FLAG
{
	JS_PARSER_KEY,					//����
	JS_PARSER_VALUE,				//��ֵ
};

//����״̬
enum JS_PARSER_OBJ_STATE
{
	JS_PARSER_OBJ_START,			//��ʼ����json����
	JS_PARSER_OBJ_END,				//��ɽ���json����
	JS_PARSER_OBJ_ERR,				//����json�����쳣
};

enum JS_PARSER_MEM_STATE
{
	JS_PARSER_MEM_START,			//��ʼ����jsonԪ��
	JS_PARSER_MEM_END,				//��ɽ���jsonԪ��
	JS_PARSER_MEM_ERR,				//����jsonԪ���쳣
};

enum JS_PARSER_KEY_STATE
{
	JS_PARSER_KEY_START,			//��ʼ����json����
	JS_PARSER_KEY_END,				//��ɽ���json����
	JS_PARSER_KEY_ERR,				//����json�����쳣
};

enum JS_PARSER_VAL_STATE
{
	JS_PARSER_VAL_START,			//��ʼ����json��ֵ
	JS_PARSER_VAL_END,				//��ɽ���json��ֵ
	JS_PARSER_VAL_ERR,				//����json��ֵ�쳣
};

enum JS_PARSER_ARR_STATE
{
	JS_PARSER_ARR_START,			//��ʼ����json����
	JS_PARSER_ARR_END,				//��ɽ���json����
	JS_PARSER_ARR_ERR,				//����json�����쳣
};

enum JS_PARSER_STR_STATE
{
	JS_PARSER_STR_START,			//��ʼ����json�ַ���
	JS_PARSER_STR_CONTINUE,			//��������json�ַ���
	JS_PARSER_STR_END,				//��ɽ���json�ַ���
	JS_PARSER_STR_ERR,				//����json�ַ����쳣
};

enum JS_PARSER_DATA_STATE
{
	JS_PARSER_DATA_START,			//��ʼ����json����
	JS_PARSER_DATA_END,				//��ɽ���json����
	JS_PARSER_DATA_ERR,				//����json�����쳣
};

//����״̬
#define JS_RET_SUCCESS		0
#define JS_RET_FAILED		-1
#define JS_RET_EXECUTE		1


/* ����json����
 * param parent_data: ���ڵ�����ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_object(void **parent_data,  char *buffer, int *index);

/* json�������״̬��
 * param object: ����ڵ�ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_object_state(PJOBJECT object,  char *buffer, int *index);

/* ����jsonԪ��
 * param parent_data: ���ڵ�����ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_member(void **parent_data, char *buffer, int *index);

/* jsonԪ�ؽ���״̬��
 * param member: Ԫ�ؽڵ�ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_member_state(PJMEMBER member, char *buffer, int *index);

/* ����json����
 * param parent_data: ���ڵ�����ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_key(void **parent_data,  char *buffer, int *index);

/* json��������״̬��
 * param key: �����ڵ�ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_key_state(PJKEY key, char *buffer, int *index);

/* ����json��ֵ
 * param parent_data: ���ڵ�����ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_value(void **parent_data, char *buffer, int *index);

/* json��ֵ����״̬��
 * param value: ��ֵ�ڵ�ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_value_state(PJVALUE value, char *buffer, int *index);

/* ����json����
 * param parent_data: ���ڵ�����ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_array(void **parent_data, char *buffer, int *index);

/* json�������״̬��
 * param array: ����ڵ�ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_array_state(PJARRAY array, char *buffer, int *index);

/* ����json�ַ���
 * param parent_data: ���ڵ�����ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_string(void **parent_data, char *buffer, int *index);

/* json�ַ�������״̬��
 * param string: �ַ����ڵ�ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_string_state(PJSTRING string, char *buffer, int *index);

/* ����json����
 * param parent_data: ���ڵ�����ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_data(void **parent_data, char *buffer, int *index);

/* json���ݽ���״̬��
 * param data: ���ݽڵ�ָ��
 * param buffer: �ַ�������
 * param index: ��ǰ�ַ�indexֵ
 * ret: ���գ�JS_RET_STATE��
 */
int Js_parser_data_state(PJDATA data, char *buffer, int *index);

/* �ͷ�json����
 * param object: ����ָ��
 */
void Js_parser_object_free(PJOBJECT object);

/* �ͷ�jsonԪ��
 * param member: Ԫ��ָ��
 */
void Js_parser_member_free(PJMEMBER member);

/* �ͷ�json����
 * param key: ����ָ��
 */
void Js_parser_key_free(PJKEY key);

/* �ͷ�json��ֵ
 * param value: ��ֵָ��
 */
void Js_parser_value_free(PJVALUE value);

/* �ͷ�json����
 * param array: ����ָ��
 */
void Js_parser_array_free(PJARRAY array);

/* �ͷ�json�ַ���
 * param string: �ַ���ָ��
 */
void Js_parser_string_free(PJSTRING string);

/* �ͷ�json����
 * param data: ����ָ��
 */
void Js_parser_data_free(PJDATA data);

/* ��ȡjson����
 * param object: ����ָ��
 * param key: ��������
 * ret:��ֵ�ṹָ��
 */
void *Js_object_get_value(PJOBJECT object, char *key);

/* ��ȡjson����
 * param member: Ԫ��ָ��
 * param key: ��������
 * ret:��ֵ�ṹָ��
 */
void *Js_member_get_value(PJMEMBER member, char *key);

/* �жϼ����Ƿ����
 * param key: ����ָ��
 * param key_name: ��������
 * ret: TRUE(���), FALSE(����)
 */
int Js_key_is_equal(PJKEY key, char *key_name);

/* ���������ȡ����
 * param array: ����ָ��
 * param index: ����ֵ
 * ret: ��ֵ�ṹָ��
 */
void *Js_array_get_value(PJARRAY array, int index);

/* ��ȡ�����С
 * param array: ����ָ��
 * ret: �����С
 */
int Js_array_get_count(PJARRAY array);

#ifdef __cplusplus
}
#endif

#endif