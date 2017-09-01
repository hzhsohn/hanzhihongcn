#include "js_parser.h"

int Js_parser_object(void **parent_data, char *buffer, int *index)
{
	PJOBJECT object = NULL;
	int ret = 0;

	if(parent_data == NULL)
		return JS_RET_FAILED;
	
	object = (PJOBJECT)Js_mem_malloc(sizeof(JOBJECT));
	Js_memset(object, 0x0, sizeof(JOBJECT));

	*parent_data = object;

	while(*(buffer + *index) != '\0')
	{
		ret = Js_parser_object_state(object, buffer, index);

		if(ret != JS_RET_EXECUTE)
		{
			return ret;
		}
	}
	return JS_RET_SUCCESS;
}

int Js_parser_object_state(PJOBJECT object, char *buffer, int *index)
{
	int ret = 0;
	char *ch = buffer + (*index);

	switch(object->obj_state)
	{
	//��ʼ����json����
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��2�������������{�����ַ�����������������Ԫ��
	 * ��3����������������ַ�����ת��JS_PARSER_OBJ_ERR
	 */
	case JS_PARSER_OBJ_START:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			else if(*ch == '{')
			{
				(*index)++;
				ret = Js_parser_member(&(object->obj_data), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
			else if(*ch == '}')
			{
				object->obj_state = JS_PARSER_OBJ_END;
			}
			else
			{
				//��������
				object->obj_state = JS_PARSER_OBJ_ERR;
			}
		}
		break;
	//��ɽ���json����
	/*
	 * ��1�������������}�����ַ�������
	 * ��2����������������ַ�����ת��JS_PARSER_OBJ_ERR
	 */
	case JS_PARSER_OBJ_END:
		{
			if(*ch == '}')
			{
				(*index)++;
				return JS_RET_SUCCESS;
			}
			else
			{
				object->obj_state = JS_PARSER_OBJ_ERR;
			}
		}
		break;
	//����json�����쳣
	case JS_PARSER_OBJ_ERR:
		{
			return JS_RET_FAILED;
		}
		break;
	}
	TRACE("OBJECT---ch = %c, state = %d, obj_data = 0x%x\n", *ch, object->obj_state, &(object->obj_data));
	return JS_RET_EXECUTE;
}

int Js_parser_member(void **parent_data, char *buffer, int *index)
{
	PJMEMBER member = NULL;
	int ret = 0;

	if(parent_data == NULL)
		return JS_RET_FAILED;

	member = (PJMEMBER)Js_mem_malloc(sizeof(JMEMBER));
	Js_memset(member, 0x0, sizeof(JMEMBER));

	*parent_data = member;

	while(*(buffer + *index) != '\0')
	{
		ret = Js_parser_member_state(member, buffer, index);

		if(ret != JS_RET_EXECUTE)
		{
			return ret;
		}
	}
	return JS_RET_FAILED;
}

int Js_parser_member_state(PJMEMBER member, char *buffer, int *index)
{
	int ret = 0;
	char *ch = buffer + (*index);

	switch(member->mem_state)
	{
	//��ʼ����jsonԪ��
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��2�������������"��������״̬���ַ�����������������
	 * ��3�������������,��������״̬���ַ���������������һԪ�ؼ���
	 * ��4�������������:��������״̬���ַ���������������ֵ
	 * ��5�������������}������ת��JS_PARSER_MEM_END
	 * ��6����������������ַ�����ת��JS_PARSER_MEM_ERR
	 */
	case JS_PARSER_MEM_START:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			else if(*ch == '\"')
			{
				ret = Js_parser_key(&(member->mem_key), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
			else if(*ch == ',')
			{
				(*index)++;
				return Js_parser_member(&(member->mem_next), buffer, index);
			}
			else if(*ch == ':')
			{
				(*index)++;
				ret = Js_parser_value(&(member->mem_value), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
			else if(*ch == '}')
			{
				member->mem_state = JS_PARSER_MEM_END;
			}
			else
			{
				member->mem_state = JS_PARSER_MEM_ERR;
			}
		}
		break;
	//��ɽ���json����
	case JS_PARSER_MEM_END:
		{
			return JS_RET_SUCCESS;
		}
		break;
	//����json�����쳣
	case JS_PARSER_MEM_ERR:
		{
			return JS_RET_FAILED;
		}
		break;
	}
	TRACE("MEMBER---ch = %c, state = %d, mem_key = 0x%x, mem_value = 0x%x\n", *ch, member->mem_state, &(member->mem_key), &(member->mem_value));
	return JS_RET_EXECUTE;
}


int Js_parser_key(void **parent_data, char *buffer, int *index)
{
	PJKEY key = NULL;
	int ret = 0;

	if(parent_data == NULL)
		return JS_RET_FAILED;

	key = (PJKEY)Js_mem_malloc(sizeof(JKEY));
	Js_memset(key, 0x0, sizeof(JKEY));

	*parent_data = key;

	while(*(buffer + *index) != '\0')
	{
		ret = Js_parser_key_state(key, buffer, index);

		if(ret != JS_RET_EXECUTE)
		{
			return ret;
		}
	}
	return JS_RET_FAILED;
}

int Js_parser_key_state(PJKEY key, char *buffer, int *index)
{
	int ret = 0;
	char *ch = buffer + (*index);

	switch(key->key_state)
	{
	//��ʼ����json����
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��2�������������"��������״̬�����ü������ͣ������ַ���
	 * ��3�������������:������ת��JS_PARSER_KEY_END
	 * ��4����������������ַ�����ת��JS_PARSER_KEY_ERR
	 */
	case JS_PARSER_KEY_START:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			else if(*ch == '\"')
			{
				key->key_type = JS_STRING;
				ret = Js_parser_string(&(key->key_data), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
			else if(*ch == ':')
			{
				key->key_state = JS_PARSER_KEY_END;
			}
			else
			{
				key->key_state = JS_PARSER_KEY_ERR;
			}
		}
		break;
	//���json��������
	case JS_PARSER_KEY_END:
		{
			return JS_RET_SUCCESS;
		}
		break;
	//����json�����쳣
	case JS_PARSER_KEY_ERR:
		{
			return JS_RET_FAILED;
		}
		break;
	}
	TRACE("KEY---ch = %c, state = %d, key_data = 0x%x\n", *ch, key->key_state, &(key->key_data));
	return JS_RET_EXECUTE;
}

int Js_parser_value(void **parent_data, char *buffer, int *index)
{
	PJVALUE value = NULL;
	int ret = 0;

	if(parent_data == NULL)
		return JS_RET_FAILED;

	value = (PJVALUE)Js_mem_malloc(sizeof(JVALUE));
	Js_memset(value, 0x0, sizeof(JVALUE));

	*parent_data = value;

	while(*(buffer + *index) != '\0')
	{
		ret = Js_parser_value_state(value, buffer, index);

		if(ret != JS_RET_EXECUTE)
		{
			return ret;
		}
	}
	return JS_RET_FAILED;
}


int Js_parser_value_state(PJVALUE value, char *buffer, int *index)
{
	int ret = 0;
	char *ch = buffer + (*index);

	switch(value->value_state)
	{
	//��ʼ����json��ֵ
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��2�������������{��������״̬�����ü�ֵ����ΪOBJECT����������
	 * ��3�������������[��������״̬�����ü�ֵ����ΪARRAY���������飬�ַ�������
	 * ��4�������������"��������״̬�����ü�ֵ����ΪSTRING�������ַ���
	 * ��5�������������}�����ߡ�]�����ߡ�,������ת��JS_PARSER_KEY_END
	 * ��6����������������ַ�������״̬�����ü�ֵ����ΪDATA����������
	 */
	case JS_PARSER_VAL_START:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			else if(*ch == '{')
			{
				value->value_type = JS_OBJECT;
				ret = Js_parser_object(&(value->value_data), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
			else if(*ch == '[')
			{
				(*index)++;
				value->value_type = JS_ARRAY;
				ret = Js_parser_array(&(value->value_data), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
			else if(*ch == '\"')
			{
				value->value_type = JS_STRING;
				ret = Js_parser_string(&(value->value_data), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
			else if(*ch == ']' || *ch == '}' || *ch == ',')
			{
				value->value_state = JS_PARSER_VAL_END;
			}
			else
			{
				value->value_type = JS_DATA;
				ret = Js_parser_data(&(value->value_data), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
		}
		break;
	//���json��ֵ����
	case JS_PARSER_VAL_END:
		{
			return JS_RET_SUCCESS;
		}
		break;
	//����json��ֵ�쳣
	case JS_PARSER_VAL_ERR:
		{
			return JS_RET_FAILED;
		}
		break;
	}
	TRACE("VALUE---ch = %c, state = %d, value_data = 0x%x\n", *ch, value->value_state, &(value->value_data));
	return JS_RET_EXECUTE;
}

int Js_parser_array(void **parent_data, char *buffer, int *index)
{
	PJARRAY array = NULL;
	int ret = 0;

	if(parent_data == NULL)
		return JS_RET_FAILED;

	array = (PJARRAY)Js_mem_malloc(sizeof(JARRAY));
	Js_memset(array, 0x0, sizeof(JARRAY));

	*parent_data = array;

	while(*(buffer + *index) != '\0')
	{
		ret = Js_parser_array_state(array, buffer, index);

		if(ret != JS_RET_EXECUTE)
		{
			return ret;
		}
	}
	return JS_RET_FAILED;
}

int Js_parser_array_state(PJARRAY array, char *buffer, int *index)
{
	int ret = 0;
	char *ch = buffer + (*index);

	switch(array->array_state)
	{
	//��ʼ����json����
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��3�������������,��������״̬��������һ����Ԫ��
	 * ��4�������������]������ת��JS_PARSER_ARR_END
	 * ��5����������������ַ�������״̬���ַ���������������ֵ
	 */
	case JS_PARSER_ARR_START:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			else if(*ch == ',')
			{
				(*index)++;
				return Js_parser_array(&(array->array_next), buffer, index);
			}
			else if(*ch == ']')
			{
				array->array_state = JS_PARSER_ARR_END;
			}
			else
			{
				ret = Js_parser_value(&(array->array_data), buffer, index);

				if(ret != JS_RET_FAILED)
					return JS_RET_EXECUTE;
			}
		}
		break;
	//��ɽ���json����
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��2�������������]�����ַ����������������
	 * ��3����������������ַ�����ת��JS_PARSER_ARR_ERR
	 */
	case JS_PARSER_ARR_END:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			else if(*ch == ']')
			{
				(*index)++;
				return JS_RET_SUCCESS;
			}
			else
			{
				array->array_state = JS_PARSER_ARR_ERR;
			}
		}
		break;
	//����json�����쳣
	case JS_PARSER_ARR_ERR:
		{
			//����
			return JS_RET_FAILED;
		}
		break;
	}
	TRACE("ARRAY---ch = %c, state = %d, array_data = 0x%x\n", *ch, array->array_state, &(array->array_data));
	return JS_RET_EXECUTE;
}

int Js_parser_string(void **parent_data, char *buffer, int *index)
{
	PJSTRING string = NULL;
	int ret = 0;

	if(parent_data == NULL)
	return JS_RET_FAILED;

	string = (PJSTRING)Js_mem_malloc(sizeof(JSTRING));
	Js_memset(string, 0x0, sizeof(JSTRING));

	*parent_data = string;

	while(*(buffer + *index) != '\0')
	{
		ret = Js_parser_string_state(string, buffer, index);

		if(ret != JS_RET_EXECUTE)
		{
			return ret;
		}
	}
	return JS_RET_FAILED;
}

int Js_parser_string_state(PJSTRING string, char *buffer, int *index)
{
	int ret = 0;
	char *ch = buffer + (*index);

	switch(string->str_state)
	{
	//��ʼ����json�ַ���
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��2�������������"������ת��JS_PARSER_STR_START���ַ�������
	 * ��3����������������ַ�����ת��JS_PARSER_STR_ERR
	 */
	case JS_PARSER_STR_START:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			if(*ch == '\"')
			{
				string->str_state = JS_PARSER_STR_CONTINUE;
				(*index)++;
			}
			else
			{
				string->str_state = JS_PARSER_STR_ERR;
				//string->str_state = JS_PARSER_STR_CONTINUE;
			}
		}
		break;
	//��������json�ַ���
	/*
	 * ��1�������������"�������ǰһ�ַ�Ϊ��\���������ַ����ַ�������
	 * ��2�������������"�������ǰһ�ַ���Ϊ��\������ת��JS_PARSER_STR_END���ַ�������
	 * ��3����������������ַ�������״̬�������ַ����ַ�������
	 */
	case JS_PARSER_STR_CONTINUE:
		{
			if(*(ch - 1) == '\\' && *ch == '\"')
			{
				//�����ַ�
				if(string->str_data == NULL)
					string->str_data = ch;

				string->str_len++;
				(*index)++;
			}
			else if(*ch == '\"')
			{
				string->str_state = JS_PARSER_STR_END;
			}
			else
			{
				//�����ַ�
				if(string->str_data == NULL)
					string->str_data = ch;

				string->str_len++;
				(*index)++;
			}
		}
		break;
	//��ɽ���json�ַ���
	/*
	 * ��1�������������"�����ַ����������������
	 * ��2����������������ַ�����ת��JS_PARSER_STR_ERR
	 */
	case JS_PARSER_STR_END:
		{
			if(*ch == '\"')
			{
				(*index)++;
				return JS_RET_SUCCESS;
			}
			else
			{
				string->str_state = JS_PARSER_STR_ERR;
			}
		}
		break;
	//����json�ַ����쳣
	case JS_PARSER_STR_ERR:
		{
			//����
			return JS_RET_FAILED;
		}
		break;
	}
	TRACE("STRING---ch = %c, state = %d, str_data = 0x%x\n", *ch, string->str_state, &(string->str_data));
	return JS_RET_EXECUTE;
}

int Js_parser_data(void **parent_data, char *buffer, int *index)
{
	PJDATA data = NULL;
	int ret = 0;

	if(parent_data == NULL)
		return JS_RET_FAILED;

	data = (PJDATA)Js_mem_malloc(sizeof(JDATA));
	Js_memset(data, 0x0, sizeof(JDATA));

	*parent_data = data;

	while(*(buffer + *index) != '\0')
	{
		ret = Js_parser_data_state(data, buffer, index);

		if(ret != JS_RET_EXECUTE)
		{
			return ret;
		}
	}
	return JS_RET_FAILED;
}

int Js_parser_data_state(PJDATA data, char *buffer, int *index)
{
	int ret = 0;
	char *ch = buffer + (*index);

	switch(data->data_state)
	{
	//��ʼ����json����
	/*
	 * ��1������������� ��������״̬���ַ�������
	 * ��2�������������}�����ߡ�]�����ߡ�,�����ߡ�:������ת��JS_PARSER_STR_END
	 * ��3����������������ַ�������״̬�������ַ����ַ�������
	 */
	case JS_PARSER_DATA_START:
		{
			if(*ch == ' ' || *ch == '\n' || *ch == '\t')
			{
				(*index)++;
			}
			else if(*ch == '}' || *ch == ']' || *ch == ',' || *ch == ':')
			{
				data->data_state = JS_PARSER_DATA_END;
			}
			else
			{					
				//�����ַ�
				if(data->data_data == NULL)
					data->data_data = ch;

				data->data_len++;
				(*index)++;
			}
		}
		break;
	//��ɽ���json����
	case JS_PARSER_DATA_END:
		{
			//����
			return JS_RET_SUCCESS;
		}
		break;
	//����json�ַ����쳣
	case JS_PARSER_DATA_ERR:
		{
			//����
			return JS_RET_FAILED;
		}
		break;
	}
	TRACE("DATA---ch = %c, state = %d, data_data = 0x%x\n", *ch, data->data_state, &(data->data_data));
	return JS_RET_EXECUTE;
}

void Js_parser_object_free(PJOBJECT object)
{
	if(object == NULL)
		return;

	Js_parser_member_free((PJMEMBER)object->obj_data);

	Js_mem_free(object);
}

void Js_parser_member_free(PJMEMBER member)
{
	if(member == NULL)
		return;

	Js_parser_key_free((PJKEY)member->mem_key);

	Js_parser_value_free((PJVALUE)member->mem_value);
	
	Js_parser_member_free(member->mem_next);

	Js_mem_free(member);
}

void Js_parser_key_free(PJKEY key)
{
	if(key == NULL)
		return;

	Js_parser_string_free((PJSTRING)key->key_data);

	Js_mem_free(key);
}

void Js_parser_value_free(PJVALUE value)
{
	if(value == NULL)
		return;

	if(value->value_type == JS_OBJECT)
	{
		Js_parser_object_free((PJOBJECT)value->value_data);
	}
	else if(value->value_type == JS_ARRAY)
	{
		Js_parser_array_free((PJARRAY)value->value_data);
	}
	else if(value->value_type == JS_STRING)
	{
		Js_parser_string_free((PJSTRING)value->value_data);
	}
	else if(value->value_type == JS_DATA)
	{
		Js_parser_data_free((PJDATA)value->value_data);
	}
}

void Js_parser_array_free(PJARRAY array)
{
	if(array == NULL)
		return;

	Js_parser_value_free((PJVALUE)array->array_data);
	
	Js_parser_array_free(array->array_next);

	Js_mem_free(array);

}

void Js_parser_string_free(PJSTRING string)
{
	if(string == NULL)
		return;

	Js_mem_free(string);
}

void Js_parser_data_free(PJDATA data)
{
	if(data == NULL)
		return;

	Js_mem_free(data);
}

void *Js_object_get_value(PJOBJECT object, char *key)
{
	if(object == NULL)
		return NULL;

	return Js_member_get_value((PJMEMBER)(object->obj_data), key);
}

void *Js_member_get_value(PJMEMBER member, char *key)
{
	if(member == NULL)
		return NULL;

	if(Js_key_is_equal((PJKEY)(member->mem_key), key))
		return member->mem_value;
	else
		return Js_member_get_value(member->mem_next, key);
}

int Js_key_is_equal(PJKEY key, char *key_name)
{
	PJSTRING str = (PJSTRING)(key->key_data);

	if(Js_strncmp(key_name, str->str_data, str->str_len))
		return FALSE;

	return TRUE;
}

void *Js_array_get_value(PJARRAY array, int index)
{
	int count = 0;
	
	for(count = 0; array != NULL; array = array->array_next, count++)
	{
		if(count == index)
			return array->array_data;
	}
	return NULL;
}

int Js_array_get_count(PJARRAY array)
{
	int count = 0;

	for(count = 0; array != NULL; count++, array = array->array_next);

	return count;
}
