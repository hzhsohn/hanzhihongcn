#pragma once

/*
* Copyright (c) 2004, game carrier
* All rights reserved.

* Filename: GCSMemManager.h
* Description:

* Author:bloodspider
* Time:2007-3-31   14:59
* Modify connect:

*/

#include <stdio.h>
#include <list>
#include <wtypes.h>

using namespace std;

#pragma warning(disable:4251)

/** @defgroup Util util
*  ������
*  @author  bloodspider
*  @date    2007-7-26 17:19
*  @{
*/

/**@defgroup UtilClass class
* �ڴ����ģ����
* @author  bloodspider
* @date    12:7:2007   15:33
* @{
*/
template <typename Type> class IocpNetMemManager
{
public:
	IocpNetMemManager(void);
	~IocpNetMemManager(void);

	/** ��ʼ�� \n
	*  @param[in] szSize �����ڴ�ʱ��"Type"����
	*  @param[in] szMaxBlockCnt ������
	*  @param[in] szFreeBloackCnt ���п���
	*  @param[in] bZero �ڴ��Ƿ���0
	*  @return 
	*/
	BOOL Init(size_t szSize, size_t szMaxBlockCnt, size_t szFreeBloackCnt, BOOL bZero=TRUE);

	/** ���� \n
	*/
	VOID Destroy();
	/** ��ʼ�� \n
	*  @param[in] bZero �ڴ��Ƿ���0
	*  @return ����"Type"ָ��
	*/
	Type* MyNew(BOOL bZero=TRUE);

	/** ��ʼ�� \n
	*  @param[in] p ��ɾ����ָ��
	*  @return 
	*/
	BOOL MyDel(Type* p);

	int GetCount();

private:

	/** ��ȫ��,����֤�����̰߳�ȫ�� */
	CRITICAL_SECTION m_cs;

	/** �����ڴ����� */
	list<INT_PTR>	m_lstFreeMem;
	/** ����ʹ�õ��ڴ����� */
	list<INT_PTR>	m_lstUseMem;

	/** �����ڴ�ʱ��"Type"���� */
	size_t m_szSize;
	/** ������ */
	size_t	m_szMaxBlockCnt;
	/** ���п��� */
	size_t	m_szFreeBloackCnt;
};

template<typename Type> IocpNetMemManager<Type>::IocpNetMemManager(void)
{
	InitializeCriticalSection(&m_cs);
}

template<typename Type> IocpNetMemManager<Type>::~IocpNetMemManager(void)
{
	Destroy();
	DeleteCriticalSection(&m_cs);
}

/*
*Function name:
*
*Description:
*
*Input:	
*
*Output:
*
*Return:HRESULT
*
* Author:bloodspider
* Time:31:3:2007   15:00
*/
template<typename Type> BOOL IocpNetMemManager<Type>::Init(size_t szSize, size_t szMaxBlockCnt, size_t szFreeBloackCnt, BOOL bZero)
{
	m_szSize = szSize;
	m_szMaxBlockCnt = szMaxBlockCnt;
	m_szFreeBloackCnt = szFreeBloackCnt;

	size_t i;
	Type* pType = NULL;
	BOOL ret = TRUE;

	for(i=0; i<m_szFreeBloackCnt; i++)
	{
		pType = new Type[m_szSize];
		if(pType != NULL)
		{
			if(bZero)
			{
				ZeroMemory(pType, sizeof(Type)*m_szSize);
			}
			m_lstFreeMem.push_back((INT_PTR)pType);	
		}
		else{
			ret = FALSE;
			Destroy();
			break;
		}
	}

	return ret;
}
template<typename Type> int IocpNetMemManager<Type>::GetCount()
{
	return m_lstUseMem.size();
}
/*
*Function name:
*
*Description:
*
*Input:	
*
*Output:
*
*Return:HRESULT
*
* Author:bloodspider
* Time:31:3:2007   15:00
*/

template<typename Type> VOID IocpNetMemManager<Type>::Destroy()
{
	EnterCriticalSection(&m_cs);

	list<INT_PTR>::iterator pos;	
	Type* pType = NULL;

	for( pos = m_lstFreeMem.begin(); pos != m_lstFreeMem.end(); pos++ )
	{
		pType = (Type*)*pos;
		delete[] pType;
	}
	m_lstFreeMem.clear();

	for( pos = m_lstUseMem.begin(); pos != m_lstUseMem.end(); pos++ )
	{
		pType = (Type*)*pos;
		delete[] pType;
	}
	m_lstUseMem.clear();

	LeaveCriticalSection(&m_cs);
}

/*
*Function name:
*
*Description:
*
*Input:	
*
*Output:
*
*Return:HRESULT
*
* Author:bloodspider
* Time:31:3:2007   15:00
*/

template<typename Type> Type* IocpNetMemManager<Type>::MyNew(BOOL bZero)
{
	Type* pType = NULL;

	if(m_lstUseMem.size() >= m_szMaxBlockCnt)
	{
		return NULL;
	}

	EnterCriticalSection(&m_cs);

	if(m_lstFreeMem.size() > 0)
	{
		pType = (Type*)m_lstFreeMem.front();
		m_lstFreeMem.pop_front();
		m_lstUseMem.push_back((INT_PTR)pType);	
	}
	else
	{
		pType = new Type[m_szSize];
		if(pType != NULL && bZero)
		{
			ZeroMemory(pType, sizeof(Type)*m_szSize);			
		}
		m_lstUseMem.push_back((INT_PTR)pType);	
	}

	LeaveCriticalSection(&m_cs);
	return pType;
}

/*
*Function name:
*
*Description:�����ڴ�,������,��������ڴ�,��ʹ����.����������������Ӱ��Ч��
*
*Input:	
*
*Output:
*
*Return:HRESULT
*
* Author:bloodspider
* Time:31:3:2007   15:00
*/

template<typename Type> BOOL IocpNetMemManager<Type>::MyDel(Type* p)
{
	if(p == NULL)
	{
		return TRUE;
	}

	Type* pType = (Type*)p;	
	list<INT_PTR>::iterator pos;	

	EnterCriticalSection(&m_cs);

	for( pos = m_lstUseMem.begin(); pos != m_lstUseMem.end(); pos++ )
	{
		pType = (Type*)*pos;
		if(pType == p)
		{
			m_lstUseMem.erase(pos);
			break;
		}		
	}

	if(m_lstFreeMem.size() < m_szFreeBloackCnt)
	{	
		//��ʱû�мӰ�ȫ��������ַ��ͬ��p���ܻᱻ������
		m_lstFreeMem.push_back((INT_PTR)p);	

	}
	else
	{
		delete[] p;
	}

	LeaveCriticalSection(&m_cs);

	return TRUE;
}

/** @}*/ // class

/** @}*/ // util