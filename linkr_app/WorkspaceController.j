/*
 * WorkspaceController.j
 * WorkspaceController
 *
 * Created by Thomas Ingham on Saturday, May 22, 2010
 * Copyright 2010, Coalmarch Productions, LLC. All rights reserved.
 */

@import <Foundation/CPObject.j>

@implementation WorkspaceController : CPViewController {

  /*!
    Set a view rect on this controller and all child views should take their size from this rect.
  */
  CGRect _viewRect;
  CPMutableArray _dummyData;
  
}

/*!
  We are dealing with a view controller here; not a view so we'll init to set the viewFrame and
  proceed normally.
*/
- (id)initWithViewFrame:(CGRect)aRect {
  self = [super init];
  if( self ){
    _viewRect = aRect;
  }
  return self;
}

/*!
  loadView
  @brief Manages the setup of constructs required for program function.
  
  ViewControllers don't need to have a view established until the view is actually required for
  display. We wait on the -loadView signal and *boom*
  
  Because we're using identifiers in our controls, along with delegates we don't need to have
  private copies of these objects in place. We can just filter them when events happen and save
  all that memory for other stuff.
  
 */
-(void)loadView {
  _viewRect.size.height -= 60;
  _viewRect.origin.y += 50;

  // Setup dummy data
  
  _dummyData = [[CPMutableArray alloc] init];
  
  [_dummyData addObject:[[CPDictionary alloc] initWithObjectsAndKeys:
                            @"http://www.apple.com/itunes",@"linkFrom",
                            @"/xyz",@"linkTo",
                            @"CB",@"owner"
                        ]];
  [_dummyData addObject:[[CPDictionary alloc] initWithObjectsAndKeys:
                            @"http://www.google.com/wiretunes",@"linkFrom",
                            @"/abc",@"linkTo",
                            @"CB",@"owner"
                        ]];
  [_dummyData addObject:[[CPDictionary alloc] initWithObjectsAndKeys:
                            @"http://www.microsoft.com/zune",@"linkFrom",
                            @"/666",@"linkTo",
                            @"CB",@"owner"
                        ]];

  // Tab view
  var _tabView = [[CPTabView alloc] initWithFrame:_viewRect];
  
  // Login tab
  var _loginTabViewItem = [[CPTabViewItem alloc] initWithIdentifier:@"login"];
  var _loginView = [[CPView alloc] initWithFrame:_viewRect];
  [_loginTabViewItem setLabel:@"Log In"];
  
  var emailLabel, emailField, passwordLabel, passwordField, submitButton;

  emailLabel = [CPTextField labelWithTitle:@"Email Address"];
  emailField = [CPTextField textFieldWithStringValue:@""
																				 placeholder:@"Your Account"
																				       width:_viewRect.size.width*.75];
  passwordLabel = [CPTextField labelWithTitle:@"Password"];
  passwordField = [CPSecureTextField textFieldWithStringValue:@""
                                                  placeholder:@""
                                                        width:_viewRect.size.width*.75];
  
  [emailLabel setFrameOrigin:CGPointMake( 10, 30 )];
  [emailField setFrameOrigin:CGPointMake( 10, 50 )];
  [passwordLabel setFrameOrigin:CGPointMake( 10, 90 )];
  [passwordField setFrameOrigin:CGPointMake( 10, 110 )];
  
  [_loginView addSubview:emailLabel];
  [_loginView addSubview:emailField];
  [_loginView addSubview:passwordLabel];
  [_loginView addSubview:passwordField];
  
  submitButton = [CPButton buttonWithTitle:@"Log In"];
  
  [submitButton setFrameOrigin:CGPointMake( ([passwordField bounds].size.width - [submitButton bounds].size.width)+7,
                                            150 )];
                                            
  [_loginView addSubview:submitButton];
  
  [_loginTabViewItem setView:_loginView];
  
  // Manage links tab
  // Subview will contain an add-field a table and a button bar.
  var _manageTabViewItem = [[CPTabViewItem alloc] initWithIdentifier:@"manage"];
  var _manageView = [[CPView alloc] initWithFrame:_viewRect];
  [_manageTabViewItem setLabel:@"Manage"];
  
  var manageScrollview = [[CPScrollView alloc] initWithFrame:CGRectMake(0,0,_viewRect.size.width,_viewRect.size.height-50)];
  var manageTableview = [[CPTableView alloc] initWithFrame:CGRectMake(0,0,_viewRect.size.width,_viewRect.size.height-50)];
  
  [manageScrollview setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
  
  var aKey;
  var keys = [_dummyData[0] allKeys];
  for(var i=0;i<[keys count];i++){
    aKey = keys[i];
    if( [aKey length] == 0 ){ continue; }
    var col = [[CPTableColumn alloc] initWithIdentifier:aKey];
    [[col headerView] setStringValue:aKey];
    [manageTableview addTableColumn:col];
  }
  [manageTableview setDelegate:self];
  [manageTableview setDataSource:self]; 
  
  [manageScrollview setDocumentView:manageTableview];
  [_manageView addSubview:manageScrollview];
  [_manageTabViewItem setView:_manageView];
  
  // About
  var _aboutTabViewItem = [[CPTabViewItem alloc] initWithIdentifier:@"about"];
  var _aboutView = [[CPView alloc] initWithFrame:_viewRect];
  [_aboutTabViewItem setLabel:@"About Linkr"];
  [_aboutTabViewItem setView:_aboutView];

  // Add the tabs to the tab view.
  [_tabView addTabViewItem:_loginTabViewItem];
  [_tabView addTabViewItem:_manageTabViewItem];
  [_tabView addTabViewItem:_aboutTabViewItem];
  
  [_tabView setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
  
  [self setView:_tabView];
  [manageTableview reloadData];
}

#pragma mark -
#pragma mark Table datasource methods

- (int) numberOfRowsInTableView:(CPTableView)table {

  return [_dummyData count];

}

-(id)tableView:(CPTableView)aTableView objectValueForTableColumn:(CPTableColumn)aTableColumn
		   row:(int)aRow {
		   return [_dummyData[aRow] valueForKey:[aTableColumn identifier]];
		   
}

@end
