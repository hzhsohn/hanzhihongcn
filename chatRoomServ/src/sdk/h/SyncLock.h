// TUDP.cpp : ���� DLL Ӧ�ó������ڵ㡣
//

#include "stdafx.h"
#pragma once
///////////////////////////////////////////////////////////////////////////////
// class CCriticalSection - �߳��ٽ���������
//
// ˵��:
// 1. �������ڶ��̻߳������ٽ������⣬���������� Lock��Unlock �� TryLock��
// 2. �߳�������Ƕ�׵��� Lock��Ƕ�׵��ú���������ͬ������ Unlock �ſɽ�����

class CCriticalSection
{
private:
	CRITICAL_SECTION m_Lock;

protected:
	virtual void InvokeInitialize() 
	{ 
		Lock(); 
	}
	virtual void InvokeFinalize() 
	{ 
		Unlock(); 
	}

public:
	CCriticalSection()
	{
		InitializeCriticalSection(&m_Lock);
	}

	~CCriticalSection()
	{
		DeleteCriticalSection(&m_Lock);
	}

	// ����
	void Lock()
	{
		EnterCriticalSection(&m_Lock);
	}

	//-----------------------------------------------------------------------------
	// ����: ����
	//-----------------------------------------------------------------------------
	void Unlock()
	{
		LeaveCriticalSection(&m_Lock);
	}
};

class CAutoSynchronizer
{
private:
	CCriticalSection *m_pObject;
public:
	CAutoSynchronizer(CCriticalSection* pObject)
	{ 
		m_pObject = pObject; 
		m_pObject->Lock(); 
	}

	~CAutoSynchronizer()
	{ 
		m_pObject->Unlock(); 
	}
};
