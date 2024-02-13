/*

2009年7月20

Sohn-韩智鸿

E-Mail:sohn@163.com

类主要功能：MD5加密

*/

#ifndef __MD5_H__
#define __MD5_H__

#ifdef __cplusplus
extern "C" {
#endif

/* PROTOTYPES should be set to one if and only if the compiler supports
  function argument prototyping.
  The following makes PROTOTYPES default to 0 if it has not already
  been defined with C compiler flags.
 */

#ifndef PROTOTYPES
#define PROTOTYPES 0
#endif

/* POINTER defines a generic pointer type */
typedef unsigned char *POINTER;

/* UINT2 defines a two byte word */
typedef unsigned short int UINT2;

/* UINT4 defines a four byte word */
typedef unsigned long int UINT4;

/* PROTO_LIST is defined depending on how PROTOTYPES is defined above.
If using PROTOTYPES, then PROTO_LIST returns the list, otherwise it
  returns an empty list.
 */
#if PROTOTYPES
#define PROTO_LIST(list) list
#else
#define PROTO_LIST(list) ()
#endif

/* MD5 context. */
typedef struct {
  UINT4 state[4];          /* state (ABCD) */
  UINT4 count[2];          /* number of bits, modulo 2^64 (lsb first) */
  unsigned char buffer[64];/* input buffer */
} MD5_CTX;

void MD5Init(MD5_CTX *);
void MD5Update(MD5_CTX *, unsigned char *, unsigned int);
void MD5Final(unsigned char [16], MD5_CTX *);


/* extended function */
int  MDFile(char *filename , char *digest);
void MDPrint(unsigned char digest[16]);
void MDString(char *str,char *digest);
void MDData(char *data, int len,char *digest);
char* MDStk(char *src16,char *digest33);//转换格式


#ifdef __cplusplus
}
#endif

#endif // __MD5_H__
