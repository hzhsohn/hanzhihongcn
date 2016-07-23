///////////////////////////  .h  //////////////////////////////////////
//
//  WebProc.h
//
//  Created by Han Sohn on 12-9-5.
//  Copyright (c) 2012年 Han.zhihong. All rights reserved.
//


#import <Foundation/Foundation.h>


@protocol WebPocDelegate <NSObject>

-(void) WebProcCallBackBegin:(NSURL*)url;
-(void) WebProcCallBackCookies:(NSURL*)url :(NSString*)cookie;
-(void) WebProcCallBackData:(NSURL*)url :(NSData*)data;
-(void) WebProcCallBackFail:(NSURL*)url;

@end

@interface WebProc : NSObject
{
    NSMutableData *m_btImgData;
    int m_nRecvTotal;
    int m_nByteTotal;
    bool m_bResponse;
}

@property (nonatomic,assign) id<WebPocDelegate> delegate;

-(NSString*) getAddrByWWW:(NSString*)page;
-(void) sendData:(NSString*)url parameter:(NSString*)pram;
-(void) sendData:(NSString*)url parameter:(NSString*)pram cookies:(NSString*)cookie;

@end

