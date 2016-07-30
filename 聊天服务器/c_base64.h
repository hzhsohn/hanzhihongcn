
#ifndef __CC_BASE64_DECODE_H
#define __CC_BASE64_DECODE_H

#ifdef __cplusplus
extern "C" {
#endif	
	

#include "stdio.h"
#include "stdlib.h"

static long int base64_encode( char *src,long int src_len, char *dst)
{
    long int i = 0, j = 0;
    //  printf("%ld\n",src[2]);
    char base64_map[65] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    for (; i < src_len - src_len % 3; i += 3) {
        
        //printf("%ld\n",(unsigned char)src[i]);
        //getchar();
        dst[j++] = base64_map[(src[i] >> 2) & 0x3F];
        dst[j++] = base64_map[((src[i] << 4) & 0x30) + ((src[i + 1] >> 4) & 0xF)];
        dst[j++] = base64_map[((src[i + 1] << 2) & 0x3C) + ((src[i + 2] >> 6) & 0x3)];
        dst[j++] = base64_map[src[i + 2] & 0x3F];
        //printf("%d",dst[j]);
    }
    if (src_len % 3 == 1) {
        dst[j++] = base64_map[(src[i] >> 2) & 0x3F];
        dst[j++] = base64_map[(src[i] << 4) & 0x30];
        dst[j++] = '=';
        dst[j++] = '=';
    }
    else if (src_len % 3 == 2) {
        dst[j++] = base64_map[(src[i] >> 2) & 0x3F];
        dst[j++] = base64_map[((src[i] << 4) & 0x30) + ((src[i + 1] >> 4) & 0xF)];
        dst[j++] = base64_map[(src[i + 1] << 2) & 0x3C];
        dst[j++] = '=';
    }
    
    dst[j] = '\0';
    //printf("newlength:%ld\n",j);
    return j;
}


static int _base64Decode( unsigned char *input, unsigned int input_len, unsigned char *output, unsigned int *output_len )
{	
    static char inalphabet[256], decoder[256];
    int i, bits, c, char_count, errors = 0;
	unsigned int input_idx = 0;
	unsigned int output_idx = 0;
	unsigned char alphabet[65] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

    for (i = (sizeof alphabet) - 1; i >= 0 ; i--) {
		inalphabet[alphabet[i]] = 1;
		decoder[alphabet[i]] = i;
    }

    char_count = 0;
    bits = 0;
	for( input_idx=0; input_idx < input_len ; input_idx++ ) {
		c = input[ input_idx ];
		if (c == '=')
			break;
		if (c > 255 || ! inalphabet[c])
			continue;
		bits += decoder[c];
		char_count++;
		if (char_count == 4) {
			output[ output_idx++ ] = (bits >> 16);
			output[ output_idx++ ] = ((bits >> 8) & 0xff);
			output[ output_idx++ ] = ( bits & 0xff);
			bits = 0;
			char_count = 0;
		} else {
			bits <<= 6;
		}
    }
	
	if( c == '=' ) {
		switch (char_count) {
			case 1:
				fprintf(stderr, "base64Decode: encoding incomplete: at least 2 bits missing\r\n");
				errors++;
				break;
			case 2:
				output[ output_idx++ ] = ( bits >> 10 );
				break;
			case 3:
				output[ output_idx++ ] = ( bits >> 16 );
				output[ output_idx++ ] = (( bits >> 8 ) & 0xff);
				break;
			}
	} else if ( input_idx < input_len ) {
		if (char_count) {
			fprintf(stderr, "base64 encoding incomplete: at least %d bits truncated\r\n",
					((4 - char_count) * 6));
			errors++;
		}
    }
	
	*output_len = output_idx;
	return errors;
}

static int base64Decode(unsigned char *in, unsigned int inLength, unsigned char **out)
{
	int len;
	unsigned int outLength = 0;
	
	//should be enough to store 6-bit buffers in 8-bit buffers
	len=(int)(inLength * 3.0f / 4.0f + 1);
	*out =(unsigned char*)malloc(len);
	(*out)[len-1]=0;
	if( *out ) {
		int ret = _base64Decode(in, inLength, *out, &outLength);
		
		if (ret > 0 )
		{
			printf("Base64Utils: error decoding\r\n");
			free(*out);
			*out = NULL;			
			outLength = 0;
		}
	}
    return outLength;
}


#ifdef __cplusplus
}
#endif	

#endif // __CC_BASE64_DECODE_H
