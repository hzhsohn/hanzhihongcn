//
//  ViewController.m
//  babylife
//
//  Created by Han.zh on 16/2/9.
//  Copyright © 2016年 Han.zhihong. All rights reserved.
//

#import "ViewController.h"
#import "JSONKit.h"
#import "WebProc.h"

#define extern_url @"http://hanzhihong.cn/myip/getip.i.php?title=hzh_home"
#define page_url @"http://%@/baby_life"
#define page_del_url @"http://%@/baby_life?showdelete=1"
#define page_add_url @"http://%@/baby_life?method=add&c=%@"

@interface ViewController ()<UIWebViewDelegate,UIActionSheetDelegate,WebPocDelegate>
{
    __weak IBOutlet UIActivityIndicatorView *indLoading;
    WebProc * webproc;
    NSMutableString* externIpAndPort;
}

@property (weak, nonatomic) IBOutlet UIWebView *web;
- (IBAction)btnEvent_click:(id)sender;

@end

@implementation ViewController


-(void)dealloc
{
    [[NSNotificationCenter defaultCenter] removeObserver:self];
    externIpAndPort=nil;
}

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view, typically from a nib.
    externIpAndPort=[[NSMutableString alloc]init];
    
    webproc=[[WebProc alloc] init];
    webproc.delegate=self;
    
    self.web.delegate=self;
    
    [indLoading startAnimating];
    [indLoading setHidesWhenStopped:YES];
    [indLoading setBounds:CGRectMake(0, 0, 130, 130)];
    [indLoading setBackgroundColor:[UIColor grayColor]];
    indLoading.layer.cornerRadius = 10;//设置那个圆角的有多圆
    indLoading.layer.borderWidth = 0;//设置边框的宽度
    UILabel *lb=[[UILabel alloc] initWithFrame:CGRectMake(0, 90, 120, 22)];
    [lb setFont:[UIFont systemFontOfSize:14]];
    [lb setTextAlignment:NSTextAlignmentCenter];
    [lb setBackgroundColor:[UIColor clearColor]];
    [lb setTextColor:[UIColor whiteColor]];
    [lb setText:@"数据加载中..."];
    [indLoading addSubview:lb];
    lb=nil;
    
    // Do any additional setup after loading the view, typically from a nib.
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(loveActive:)
                                                 name:UIApplicationDidBecomeActiveNotification object:nil];
}

-(void)loveActive:(NSNotification*)notification
{
    NSLog(@"loveActive");
    
    [webproc sendData:extern_url parameter:nil];
    
//    [self loadWeb:page_url];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

-(void) loadWeb:(NSString*)url_str
{
    if (0==strncmp([url_str UTF8String], "http:", 5))
    { [self.web loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:url_str]]]; }
    else
    { [self.web loadRequest:[NSURLRequest requestWithURL:[NSURL fileURLWithPath:url_str]]]; }
}

//////////////////////
-(BOOL)webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    
    NSString*s=[[request URL] absoluteString];
    
    NSLog(@"[[request URL] absoluteString]=%@",s);
    
    return TRUE;
    
}

//开始加载数据
- (void)webViewDidStartLoad:(UIWebView *)webView {
    
    NSLog(@"web start load");
    [indLoading setHidden:NO];
    [indLoading setAlpha:1];
}

//数据加载完
- (void)webViewDidFinishLoad:(UIWebView *)webView {
    
    NSLog(@"web finish load");
    [indLoading setHidden:YES];
    [indLoading setAlpha:0];
}

- (IBAction)reshow:(id)sender
{
    if (![externIpAndPort isEqualToString:@""]) {
        NSString* url_str=[NSString stringWithFormat:page_url,externIpAndPort];
        [self loadWeb:url_str];
    }
    else{
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:nil
                                                        message:@"外网IP未获取哟"
                                                       delegate:self
                                              cancelButtonTitle:@"确定"
                                              otherButtonTitles: nil];
        [alert show];
        alert=nil;
    }
}
- (IBAction)showdelete:(id)sender
{
    if (![externIpAndPort isEqualToString:@""]) {
        NSString* url_str=[NSString stringWithFormat:page_del_url,externIpAndPort];
        [self loadWeb:url_str];
    }
    else{
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:nil
                                                        message:@"外网IP未获取哟"
                                                       delegate:self
                                              cancelButtonTitle:@"确定"
                                              otherButtonTitles: nil];
        [alert show];
        alert=nil;
    }
}


-(void) addMsg:(NSString*)msg
{
    msg=[msg stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
    NSString* url_str=[NSString stringWithFormat:page_add_url,externIpAndPort,msg];
    NSLog(@"urlstr=%@",url_str);
    [self loadWeb:url_str];
}
//////////////////////////////////////////
- (IBAction)btnEvent_click:(id)sender {
    UIButton*btn=(UIButton*)sender;
    switch (btn.tag) {
        case 1:
            [self eventMilk];
            break;
        case 2:
            [self addMsg:@"水"];
            break;
        case 3:
            [self addMsg:@"妈咪爱"];
            break;
        case 4:
            [self addMsg:@"奶瓶消毒"];
            break;
        case 5:
            [self addMsg:@"睡了"];
            break;
        case 6:
            [self addMsg:@"醒啦"];
            break;
    }
}

////////////////////////////////////
-(void)eventMilk
{
    // 创建时仅指定取消按钮
    UIActionSheet *sheet = [[UIActionSheet alloc] initWithTitle:@"每天喝杯奶,生活健康来~"
                                                       delegate:self
                                              cancelButtonTitle:@"取消"
                                         destructiveButtonTitle:@"母乳"
                                              otherButtonTitles:nil];
    
    sheet.tag=1;
    // 逐个添加按钮（比如可以是数组循环）
    [sheet addButtonWithTitle:@"奶粉:30亳升"];
    [sheet addButtonWithTitle:@"奶粉:60亳升"];
    [sheet addButtonWithTitle:@"奶粉:90亳升"];
    [sheet addButtonWithTitle:@"奶粉:120亳升"];
    [sheet addButtonWithTitle:@"奶粉:150亳升"];
    [sheet addButtonWithTitle:@"奶粉:180亳升"];
    //[sheet showInView:self.view];
    [sheet showFromRect:CGRectMake(0, 0,500,500) inView:self.view animated:YES];
    sheet=nil;
}

- (void)actionSheet:(UIActionSheet *)actionSheet clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (1!=buttonIndex) {
        NSLog(@"actionSheet.tag=%ld buttonIndex=%ld",actionSheet.tag,buttonIndex);
        switch (actionSheet.tag) {
            case 1://奶
            {
                NSString*msg=[actionSheet buttonTitleAtIndex:buttonIndex];
                [self addMsg:msg];
            }
                break;
        }
    }
    else{
        NSLog(@"actionSheet cancel");
    }
}


//////////////////////////////////////
-(void) WebProcCallBackBegin:(NSURL*)url
{
}
-(void) WebProcCallBackCookies:(NSURL*)url :(NSString*)cookie
{
}
-(void) WebProcCallBackData:(NSURL*)url :(NSData*)data
{
    NSLog(@"url=%@",url);
    NSLog(@"[url relativePath]=%@",[url relativePath]);
    if (0==[data length]) {
        return;
    }
    
    //去除UTF8标记 EF BB BF
    NSData* da = nil;
    char utf_h[]={0xEF,0xBB,0xBF};
    char* p=(char*)[data bytes];
    if (0==memcmp(p, utf_h, 3)) {
        da=[NSData dataWithBytes:p+3 length:[data length]-3];
    }
    else
    {da=data;}
    
    if([[url relativePath] isEqualToString:@"/myip/getip.i.php"])
    {
        //解释data
        NSDictionary *info = [data objectFromJSONData];
        BOOL result=[info objectForKey:@"result"];
        if (result) {
            NSString*msg=[info objectForKey:@"msg"];
            NSLog(@"msg=%@",msg);
            NSDictionary *serv =[info objectForKey:@"serv"];
            NSString*ip=[serv objectForKey:@"ip"];
            NSLog(@"ip=%@",ip);
            [externIpAndPort setString:[NSString stringWithFormat:@"%@:81",ip]];
            NSLog(@"获取外网数据成功");
            NSString* url_str=[NSString stringWithFormat:page_url,externIpAndPort];
            [self loadWeb:url_str];
        }
        else{
            UIAlertView *alert = [[UIAlertView alloc] initWithTitle:nil
                                                            message:@"获取服务器失败"
                                                           delegate:self
                                                  cancelButtonTitle:@"知道了"
                                                  otherButtonTitles: nil];
            [alert show];
            alert=nil;
        }
    }
}
-(void) WebProcCallBackFail:(NSURL*)url
{
}

@end
