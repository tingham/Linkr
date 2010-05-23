/*
 * AppController.j
 * linkr_app
 *
 * Created by Thomas Ingham on May 22, 2010.
 * Copyright 2010, Your Company All rights reserved.
 */

@import <Foundation/CPObject.j>
@import "WorkspaceController.j"

@implementation AppController : CPObject
{
  CPWindow _workWindow;
  WorkspaceController _workspaceController;
}

- (void)applicationDidFinishLaunching:(CPNotification)aNotification
{
    var theWindow = [[CPWindow alloc] initWithContentRect:CGRectMakeZero() styleMask:CPBorderlessBridgeWindowMask];
    [[theWindow contentView] setBackgroundColor:[CPColor colorWithPatternImage:[[CPImage alloc] initWithContentsOfFile:[[CPBundle mainBundle] pathForResource:@"bg.jpg"]]]];

    _workWindow = [[CPWindow alloc] initWithContentRect:CGRectMake(100,50,400,500)
                                              styleMask:CPTitledWindowMask | CPResizableWindowMask];
    
    [[_workWindow contentView] setBackgroundColor:[CPColor colorWithRed:209/255 green:209/255 blue:209/255 alpha:1.0]];
    
    contentView = [_workWindow contentView];
    _workspaceController = [[WorkspaceController alloc] initWithViewFrame:[contentView bounds]];
    
    var linkrLabel = [CPTextField labelWithTitle:@"Linkr"];
    var tagLabel = [CPTextField labelWithTitle:@"Make short links your own."];
    
    [linkrLabel setFont:[CPFont boldSystemFontOfSize:22]];
    [tagLabel setFont:[CPFont systemFontOfSize:12]];
    
    [linkrLabel setFrameOrigin:CGPointMake(5,5)];
    [tagLabel setFrameOrigin:CGPointMake(5,30)]; 
    
    [linkrLabel sizeToFit];
    [tagLabel sizeToFit];
    
    [contentView addSubview:linkrLabel];
    [contentView addSubview:tagLabel];
    [contentView addSubview:[_workspaceController view]];
    
    [theWindow orderFront:self];
    [_workWindow orderFront:self];
    
    // Uncomment the following line to turn on the standard menu bar.
    //[CPMenu setMenuBarVisible:YES];
}

@end
