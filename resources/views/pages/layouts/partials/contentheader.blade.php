<!-- header -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('img/website/logo.png') }}" alt="" class="img-responsive">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/category/view/mon-nha-nau/') }}">Món nhà nấu</a></li>
                <li><a href="{{ url('/category/view/rau-nha-trong/') }}">Rau nhà trồng</a></li>
                <!-- Menu Mobile -->
                <li class="mobile-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Món ăn<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="item-category-mobile">
                                    <h3>Meal Type</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/76/appetizers-and-snacks/" ng-click="setAnalyticsCookie('browse|appetizers \u0026 snacks')" title="Appetizers &amp; Snacks Recipes" target="_self">Appetizers &amp; Snacks</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/78/breakfast-and-brunch/" ng-click="setAnalyticsCookie('browse|breakfast \u0026 brunch')" title="Breakfast &amp; Brunch Recipes" target="_self">Breakfast &amp; Brunch</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/79/desserts/" ng-click="setAnalyticsCookie('browse|desserts')" title="Desserts Recipes" target="_self">Desserts</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/17562/dinner/" ng-click="setAnalyticsCookie('browse|dinner')" title="Dinner Recipes" target="_self">Dinner</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/77/drinks/" ng-click="setAnalyticsCookie('browse|drinks')" title="Drinks Recipes" target="_self">Drinks</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Ingredient</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/200/meat-and-poultry/beef/" ng-click="setAnalyticsCookie('browse|beef')" title="Beef Recipes" target="_self">Beef</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/201/meat-and-poultry/chicken/" ng-click="setAnalyticsCookie('browse|chicken')" title="Chicken Recipes" target="_self">Chicken</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/95/pasta-and-noodles/" ng-click="setAnalyticsCookie('browse|pasta')" title="Pasta Recipes" target="_self">Pasta</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/205/meat-and-poultry/pork/" ng-click="setAnalyticsCookie('browse|pork')" title="Pork Recipes" target="_self">Pork</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/416/seafood/fish/salmon/" ng-click="setAnalyticsCookie('browse|salmon')" title="Salmon Recipes" target="_self">Salmon</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Diet &amp; Health</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/739/healthy-recipes/diabetic/" ng-click="setAnalyticsCookie('browse|diabetic')" title="Diabetic Recipes" target="_self">Diabetic</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/741/healthy-recipes/gluten-free/" ng-click="setAnalyticsCookie('browse|gluten free')" title="Gluten Free Recipes" target="_self">Gluten Free</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/84/healthy-recipes/" ng-click="setAnalyticsCookie('browse|healthy')" title="Healthy Recipes" target="_self">Healthy</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1232/healthy-recipes/low-calorie/" ng-click="setAnalyticsCookie('browse|low calorie')" title="Low Calorie Recipes" target="_self">Low Calorie</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1231/healthy-recipes/low-fat/" ng-click="setAnalyticsCookie('browse|low fat')" title="Low Fat Recipes" target="_self">Low Fat</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Seasonal</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="http://allrecipes.com/recipes/195/holidays-and-events/ramadan/" ng-click="setAnalyticsCookie('browse|ramadan')" title="Ramadan Recipes" target="_self">Ramadan</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/1502/holidays-and-events/memorial-day/" ng-click="setAnalyticsCookie('browse|memorial day')" title="Memorial Day Recipes" target="_self">Memorial Day</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/1641/holidays-and-events/fathers-day/" ng-click="setAnalyticsCookie('browse|father\u0027s day')" title="Father's Day Recipes" target="_self">Father's Day</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/191/holidays-and-events/4th-of-july/" ng-click="setAnalyticsCookie('browse|4th of july')" title="4th of July Recipes" target="_self">4th of July</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/85/holidays-and-events/" ng-click="setAnalyticsCookie('browse|more holidays and events')" title="More Holidays and Events Recipes" target="_self">More Holidays and Events</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Dish Type</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/156/bread/" ng-click="setAnalyticsCookie('browse|breads')" title="Breads Recipes" target="_self">Breads</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/276/desserts/cakes/" ng-click="setAnalyticsCookie('browse|cakes')" title="Cakes Recipes" target="_self">Cakes</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/96/salad/" ng-click="setAnalyticsCookie('browse|salads')" title="Salads Recipes" target="_self">Salads</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/138/drinks/smoothies/" ng-click="setAnalyticsCookie('browse|smoothies')" title="Smoothies Recipes" target="_self">Smoothies</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/94/soups-stews-and-chili/" ng-click="setAnalyticsCookie('browse|soups, stews \u0026 chili')" title="Soups, Stews &amp; Chili Recipes" target="_self">Soups, Stews &amp; Chili</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Cooking Style</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/88/bbq-grilling/" ng-click="setAnalyticsCookie('browse|bbq \u0026 grilling')" title="BBQ &amp; Grilling Recipes" target="_self">BBQ &amp; Grilling</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1947/everyday-cooking/quick-and-easy/" ng-click="setAnalyticsCookie('browse|quick \u0026 easy')" title="Quick &amp; Easy Recipes" target="_self">Quick &amp; Easy</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/253/everyday-cooking/slow-cooker/" ng-click="setAnalyticsCookie('browse|slow cooker')" title="Slow Cooker Recipes" target="_self">Slow Cooker</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1227/everyday-cooking/vegan/" ng-click="setAnalyticsCookie('browse|vegan')" title="Vegan Recipes" target="_self">Vegan</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/87/everyday-cooking/vegetarian/" ng-click="setAnalyticsCookie('browse|vegetarian')" title="Vegetarian Recipes" target="_self">Vegetarian</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>World Cuisine</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/227/world-cuisine/asian/" ng-click="setAnalyticsCookie('browse|asian')" title="Asian Recipes" target="_self">Asian</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/233/world-cuisine/asian/indian/" ng-click="setAnalyticsCookie('browse|indian')" title="Indian Recipes" target="_self">Indian</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/723/world-cuisine/european/italian/" ng-click="setAnalyticsCookie('browse|italian')" title="Italian Recipes" target="_self">Italian</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/728/world-cuisine/latin-american/mexican/" ng-click="setAnalyticsCookie('browse|mexican')" title="Mexican Recipes" target="_self">Mexican</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/15876/us-recipes/southern/" ng-click="setAnalyticsCookie('browse|southern')" title="Southern Recipes" target="_self">Southern</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Special Collections</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="http://allrecipes.com/recipes/17235/everyday-cooking/allrecipes-magazine-recipes/" ng-click="setAnalyticsCookie('browse|allrecipes magazine recipes')" title="Allrecipes Magazine Recipes" target="_self">Allrecipes Magazine Recipes</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/16791/everyday-cooking/special-collections/web-show-recipes/food-wishes/" ng-click="setAnalyticsCookie('browse|food wishes with chef john')" title="Food Wishes with Chef John Recipes" target="_self">Food Wishes with Chef John</a>
                                        </li>
                                        <li>
                                            <a href="http://dish.allrecipes.com/trusted-brand-pages/" ng-click="setAnalyticsCookie('browse|trusted brands')" title="Trusted Brands Recipes" target="_self">Trusted Brands</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Nguyên liệu<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="item-category-mobile">
                                    <h3>Nguyên liệu</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/76/appetizers-and-snacks/" ng-click="setAnalyticsCookie('browse|appetizers \u0026 snacks')" title="Appetizers &amp; Snacks Recipes" target="_self">Appetizers &amp; Snacks</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/78/breakfast-and-brunch/" ng-click="setAnalyticsCookie('browse|breakfast \u0026 brunch')" title="Breakfast &amp; Brunch Recipes" target="_self">Breakfast &amp; Brunch</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/79/desserts/" ng-click="setAnalyticsCookie('browse|desserts')" title="Desserts Recipes" target="_self">Desserts</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/17562/dinner/" ng-click="setAnalyticsCookie('browse|dinner')" title="Dinner Recipes" target="_self">Dinner</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/77/drinks/" ng-click="setAnalyticsCookie('browse|drinks')" title="Drinks Recipes" target="_self">Drinks</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Ingredient</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/200/meat-and-poultry/beef/" ng-click="setAnalyticsCookie('browse|beef')" title="Beef Recipes" target="_self">Beef</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/201/meat-and-poultry/chicken/" ng-click="setAnalyticsCookie('browse|chicken')" title="Chicken Recipes" target="_self">Chicken</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/95/pasta-and-noodles/" ng-click="setAnalyticsCookie('browse|pasta')" title="Pasta Recipes" target="_self">Pasta</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/205/meat-and-poultry/pork/" ng-click="setAnalyticsCookie('browse|pork')" title="Pork Recipes" target="_self">Pork</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/416/seafood/fish/salmon/" ng-click="setAnalyticsCookie('browse|salmon')" title="Salmon Recipes" target="_self">Salmon</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Diet &amp; Health</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/739/healthy-recipes/diabetic/" ng-click="setAnalyticsCookie('browse|diabetic')" title="Diabetic Recipes" target="_self">Diabetic</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/741/healthy-recipes/gluten-free/" ng-click="setAnalyticsCookie('browse|gluten free')" title="Gluten Free Recipes" target="_self">Gluten Free</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/84/healthy-recipes/" ng-click="setAnalyticsCookie('browse|healthy')" title="Healthy Recipes" target="_self">Healthy</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1232/healthy-recipes/low-calorie/" ng-click="setAnalyticsCookie('browse|low calorie')" title="Low Calorie Recipes" target="_self">Low Calorie</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1231/healthy-recipes/low-fat/" ng-click="setAnalyticsCookie('browse|low fat')" title="Low Fat Recipes" target="_self">Low Fat</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Seasonal</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="http://allrecipes.com/recipes/195/holidays-and-events/ramadan/" ng-click="setAnalyticsCookie('browse|ramadan')" title="Ramadan Recipes" target="_self">Ramadan</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/1502/holidays-and-events/memorial-day/" ng-click="setAnalyticsCookie('browse|memorial day')" title="Memorial Day Recipes" target="_self">Memorial Day</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/1641/holidays-and-events/fathers-day/" ng-click="setAnalyticsCookie('browse|father\u0027s day')" title="Father's Day Recipes" target="_self">Father's Day</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/191/holidays-and-events/4th-of-july/" ng-click="setAnalyticsCookie('browse|4th of july')" title="4th of July Recipes" target="_self">4th of July</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/85/holidays-and-events/" ng-click="setAnalyticsCookie('browse|more holidays and events')" title="More Holidays and Events Recipes" target="_self">More Holidays and Events</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Dish Type</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/156/bread/" ng-click="setAnalyticsCookie('browse|breads')" title="Breads Recipes" target="_self">Breads</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/276/desserts/cakes/" ng-click="setAnalyticsCookie('browse|cakes')" title="Cakes Recipes" target="_self">Cakes</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/96/salad/" ng-click="setAnalyticsCookie('browse|salads')" title="Salads Recipes" target="_self">Salads</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/138/drinks/smoothies/" ng-click="setAnalyticsCookie('browse|smoothies')" title="Smoothies Recipes" target="_self">Smoothies</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/94/soups-stews-and-chili/" ng-click="setAnalyticsCookie('browse|soups, stews \u0026 chili')" title="Soups, Stews &amp; Chili Recipes" target="_self">Soups, Stews &amp; Chili</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Cooking Style</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/88/bbq-grilling/" ng-click="setAnalyticsCookie('browse|bbq \u0026 grilling')" title="BBQ &amp; Grilling Recipes" target="_self">BBQ &amp; Grilling</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1947/everyday-cooking/quick-and-easy/" ng-click="setAnalyticsCookie('browse|quick \u0026 easy')" title="Quick &amp; Easy Recipes" target="_self">Quick &amp; Easy</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/253/everyday-cooking/slow-cooker/" ng-click="setAnalyticsCookie('browse|slow cooker')" title="Slow Cooker Recipes" target="_self">Slow Cooker</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/1227/everyday-cooking/vegan/" ng-click="setAnalyticsCookie('browse|vegan')" title="Vegan Recipes" target="_self">Vegan</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/87/everyday-cooking/vegetarian/" ng-click="setAnalyticsCookie('browse|vegetarian')" title="Vegetarian Recipes" target="_self">Vegetarian</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>World Cuisine</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="/recipes/227/world-cuisine/asian/" ng-click="setAnalyticsCookie('browse|asian')" title="Asian Recipes" target="_self">Asian</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/233/world-cuisine/asian/indian/" ng-click="setAnalyticsCookie('browse|indian')" title="Indian Recipes" target="_self">Indian</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/723/world-cuisine/european/italian/" ng-click="setAnalyticsCookie('browse|italian')" title="Italian Recipes" target="_self">Italian</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/728/world-cuisine/latin-american/mexican/" ng-click="setAnalyticsCookie('browse|mexican')" title="Mexican Recipes" target="_self">Mexican</a>
                                        </li>
                                        <li>
                                            <a href="/recipes/15876/us-recipes/southern/" ng-click="setAnalyticsCookie('browse|southern')" title="Southern Recipes" target="_self">Southern</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="item-category-mobile">
                                    <h3>Special Collections</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                        <li>
                                            <a href="http://allrecipes.com/recipes/17235/everyday-cooking/allrecipes-magazine-recipes/" ng-click="setAnalyticsCookie('browse|allrecipes magazine recipes')" title="Allrecipes Magazine Recipes" target="_self">Allrecipes Magazine Recipes</a>
                                        </li>
                                        <li>
                                            <a href="http://allrecipes.com/recipes/16791/everyday-cooking/special-collections/web-show-recipes/food-wishes/" ng-click="setAnalyticsCookie('browse|food wishes with chef john')" title="Food Wishes with Chef John Recipes" target="_self">Food Wishes with Chef John</a>
                                        </li>
                                        <li>
                                            <a href="http://dish.allrecipes.com/trusted-brand-pages/" ng-click="setAnalyticsCookie('browse|trusted brands')" title="Trusted Brands Recipes" target="_self">Trusted Brands</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cách nấu<b class="caret"></b></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cảm nhận<b class="caret"></b></a>
                        </li>
                    </ul>
                </li>
                <!-- End Menu Mobile -->
                <li>
                    <form class="form-inline form-search" action="{{ url('/search') }}" method="GET">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q" id="txtSearchFood" placeholder="Tìm món ăn">
                        </div>
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </form>
                </li>
                <li class="notification">
                    <a href="" class=" noti-alert"><i class="fa fa-bell" aria-hidden="true"></i><span class="number">1</span></a>
                    <a href="" class="noti-favorite"><i class="fa fa-heart" aria-hidden="true"></i><span class="number">1</span></a>
                </li>
                <li>
                    <div class="signin {{ (Auth::check()) ? 'logged-in' : '' }}">
                        @if (Auth::check())
                            <div class="user-avatar">
                                @if (Auth::user()->image == '')
                                    <img src="{{ url('/') }}/img/website/avatar_user_default.png" alt="" class="img-responsive" >
                                @else
                                    <img src="{{ asset($ImageHelper::get_image_by_size(Auth::user()->image, '150x150')) }}" alt="" class="img-responsive">
                                @endif
                            </div>
                        @else
                            <i class="fa fa-user" aria-hidden="true"></i>
                        @endif
                        <div class="btn-signin ">
                            @if (Auth::check())
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                    <div class="user-controls">
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </div>
                                </a> 

                                <ul class="dropdown-menu">
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-top">
                                            <a href="{{ url('/profile/'.Auth::user()->id) }}" class="btn btn-default btn-flat">Thông tin</a>
                                        </div>
                                        <div class="pull-bottom">
                                            <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">Đăng xuất
                                            </a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="submit" value="logout" style="display: none;">
                                            </form>

                                        </div>
                                    </li>
                                </ul>  
                            @else
                                <a href="{{ url('/login') }}">Đăng nhập</a>
                            @endif                       
                        </div>
                        @if (Auth::check())
                            
                        @endif
                    </div>
                </li>
            </ul>
            <!-- <button><i class="fa fa-times" aria-hidden="true"></i></button> -->
            <button class="btn-menu"><i class="fa fa-bars" aria-hidden="true"></i></button>
        </div>
        <!--/.navbar-collapse -->
    </div>
    <div class="sub-menu">
        <div class="container">
            <ul class="list-inline">
                <li>
                    <a href="" class="item-sub-menu" popup-control="detail-mon-an">Món ăn</a>
                </li>
                <li>
                    <a href="" class="item-sub-menu" popup-control="detail-nguyen-lieu">Nguyên liệu</a>
                </li>
                <li>
                    <a href="" class="item-sub-menu" popup-control="detail-cach-nau">Cách nấu</a>
                </li>
                <li>
                    <a href="" class="item-sub-menu" popup-control="detail-cam-nhan">Cảm nhận</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="categories" id="detail-mon-an">
        <section class="section-categories">
            <div class="container">
                <div class="all-categories-container">
                    <ul class="list-unstyled all-categories-list">
                        @foreach ($categories_menu as $category_parent)
                            @if ($category_parent->parent_id == 0)
                                <li class="item-category">
                                    <h3>{{ $category_parent->name }}</h3>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    <ul class="list-unstyled sub-categories-list">
                                    @foreach ($categories_menu as $category_child)
                                        @if($category_parent->id == $category_child->parent_id)
                                            <li>
                                                <a href="{{ route('website_category_view', ['category_slug' => $category_child->slug]) }}" title="{{ $category_child->name }}" target="_self">{{ $category_child->name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                    </ul>
                                </li>
                            @endif
                                
                        @endforeach
                    </ul>
                    <div class="all-categories-link">
                        <div class="recipe-hero-link__item__text">All Categories</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="categories" id="detail-nguyen-lieu">
        <section class="section-categories">
            <div class="container">
                <div class="all-categories-container" style="display: none;">
                    <ul class="list-unstyled all-categories-list">
                        <li class="item-category">
                            <h3>Nguyên liệu</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="/recipes/76/appetizers-and-snacks/" ng-click="setAnalyticsCookie('browse|appetizers \u0026 snacks')" title="Appetizers &amp; Snacks Recipes" target="_self">Appetizers &amp; Snacks</a>
                                </li>
                                <li>
                                    <a href="/recipes/78/breakfast-and-brunch/" ng-click="setAnalyticsCookie('browse|breakfast \u0026 brunch')" title="Breakfast &amp; Brunch Recipes" target="_self">Breakfast &amp; Brunch</a>
                                </li>
                                <li>
                                    <a href="/recipes/79/desserts/" ng-click="setAnalyticsCookie('browse|desserts')" title="Desserts Recipes" target="_self">Desserts</a>
                                </li>
                                <li>
                                    <a href="/recipes/17562/dinner/" ng-click="setAnalyticsCookie('browse|dinner')" title="Dinner Recipes" target="_self">Dinner</a>
                                </li>
                                <li>
                                    <a href="/recipes/77/drinks/" ng-click="setAnalyticsCookie('browse|drinks')" title="Drinks Recipes" target="_self">Drinks</a>
                                </li>
                            </ul>
                        </li>
                        <li class="item-category">
                            <h3>Ingredient</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="/recipes/200/meat-and-poultry/beef/" ng-click="setAnalyticsCookie('browse|beef')" title="Beef Recipes" target="_self">Beef</a>
                                </li>
                                <li>
                                    <a href="/recipes/201/meat-and-poultry/chicken/" ng-click="setAnalyticsCookie('browse|chicken')" title="Chicken Recipes" target="_self">Chicken</a>
                                </li>
                                <li>
                                    <a href="/recipes/95/pasta-and-noodles/" ng-click="setAnalyticsCookie('browse|pasta')" title="Pasta Recipes" target="_self">Pasta</a>
                                </li>
                                <li>
                                    <a href="/recipes/205/meat-and-poultry/pork/" ng-click="setAnalyticsCookie('browse|pork')" title="Pork Recipes" target="_self">Pork</a>
                                </li>
                                <li>
                                    <a href="/recipes/416/seafood/fish/salmon/" ng-click="setAnalyticsCookie('browse|salmon')" title="Salmon Recipes" target="_self">Salmon</a>
                                </li>
                            </ul>
                        </li>
                        <li class="item-category">
                            <h3>Diet &amp; Health</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="/recipes/739/healthy-recipes/diabetic/" ng-click="setAnalyticsCookie('browse|diabetic')" title="Diabetic Recipes" target="_self">Diabetic</a>
                                </li>
                                <li>
                                    <a href="/recipes/741/healthy-recipes/gluten-free/" ng-click="setAnalyticsCookie('browse|gluten free')" title="Gluten Free Recipes" target="_self">Gluten Free</a>
                                </li>
                                <li>
                                    <a href="/recipes/84/healthy-recipes/" ng-click="setAnalyticsCookie('browse|healthy')" title="Healthy Recipes" target="_self">Healthy</a>
                                </li>
                                <li>
                                    <a href="/recipes/1232/healthy-recipes/low-calorie/" ng-click="setAnalyticsCookie('browse|low calorie')" title="Low Calorie Recipes" target="_self">Low Calorie</a>
                                </li>
                                <li>
                                    <a href="/recipes/1231/healthy-recipes/low-fat/" ng-click="setAnalyticsCookie('browse|low fat')" title="Low Fat Recipes" target="_self">Low Fat</a>
                                </li>
                            </ul>
                        </li>
                        <li class="item-category">
                            <h3>Seasonal</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="http://allrecipes.com/recipes/195/holidays-and-events/ramadan/" ng-click="setAnalyticsCookie('browse|ramadan')" title="Ramadan Recipes" target="_self">Ramadan</a>
                                </li>
                                <li>
                                    <a href="http://allrecipes.com/recipes/1502/holidays-and-events/memorial-day/" ng-click="setAnalyticsCookie('browse|memorial day')" title="Memorial Day Recipes" target="_self">Memorial Day</a>
                                </li>
                                <li>
                                    <a href="http://allrecipes.com/recipes/1641/holidays-and-events/fathers-day/" ng-click="setAnalyticsCookie('browse|father\u0027s day')" title="Father's Day Recipes" target="_self">Father's Day</a>
                                </li>
                                <li>
                                    <a href="http://allrecipes.com/recipes/191/holidays-and-events/4th-of-july/" ng-click="setAnalyticsCookie('browse|4th of july')" title="4th of July Recipes" target="_self">4th of July</a>
                                </li>
                                <li>
                                    <a href="http://allrecipes.com/recipes/85/holidays-and-events/" ng-click="setAnalyticsCookie('browse|more holidays and events')" title="More Holidays and Events Recipes" target="_self">More Holidays and Events</a>
                                </li>
                            </ul>
                        </li>
                        <li class="item-category">
                            <h3>Dish Type</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="/recipes/156/bread/" ng-click="setAnalyticsCookie('browse|breads')" title="Breads Recipes" target="_self">Breads</a>
                                </li>
                                <li>
                                    <a href="/recipes/276/desserts/cakes/" ng-click="setAnalyticsCookie('browse|cakes')" title="Cakes Recipes" target="_self">Cakes</a>
                                </li>
                                <li>
                                    <a href="/recipes/96/salad/" ng-click="setAnalyticsCookie('browse|salads')" title="Salads Recipes" target="_self">Salads</a>
                                </li>
                                <li>
                                    <a href="/recipes/138/drinks/smoothies/" ng-click="setAnalyticsCookie('browse|smoothies')" title="Smoothies Recipes" target="_self">Smoothies</a>
                                </li>
                                <li>
                                    <a href="/recipes/94/soups-stews-and-chili/" ng-click="setAnalyticsCookie('browse|soups, stews \u0026 chili')" title="Soups, Stews &amp; Chili Recipes" target="_self">Soups, Stews &amp; Chili</a>
                                </li>
                            </ul>
                        </li>
                        <li class="item-category">
                            <h3>Cooking Style</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="/recipes/88/bbq-grilling/" ng-click="setAnalyticsCookie('browse|bbq \u0026 grilling')" title="BBQ &amp; Grilling Recipes" target="_self">BBQ &amp; Grilling</a>
                                </li>
                                <li>
                                    <a href="/recipes/1947/everyday-cooking/quick-and-easy/" ng-click="setAnalyticsCookie('browse|quick \u0026 easy')" title="Quick &amp; Easy Recipes" target="_self">Quick &amp; Easy</a>
                                </li>
                                <li>
                                    <a href="/recipes/253/everyday-cooking/slow-cooker/" ng-click="setAnalyticsCookie('browse|slow cooker')" title="Slow Cooker Recipes" target="_self">Slow Cooker</a>
                                </li>
                                <li>
                                    <a href="/recipes/1227/everyday-cooking/vegan/" ng-click="setAnalyticsCookie('browse|vegan')" title="Vegan Recipes" target="_self">Vegan</a>
                                </li>
                                <li>
                                    <a href="/recipes/87/everyday-cooking/vegetarian/" ng-click="setAnalyticsCookie('browse|vegetarian')" title="Vegetarian Recipes" target="_self">Vegetarian</a>
                                </li>
                            </ul>
                        </li>
                        <li class="item-category">
                            <h3>World Cuisine</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="/recipes/227/world-cuisine/asian/" ng-click="setAnalyticsCookie('browse|asian')" title="Asian Recipes" target="_self">Asian</a>
                                </li>
                                <li>
                                    <a href="/recipes/233/world-cuisine/asian/indian/" ng-click="setAnalyticsCookie('browse|indian')" title="Indian Recipes" target="_self">Indian</a>
                                </li>
                                <li>
                                    <a href="/recipes/723/world-cuisine/european/italian/" ng-click="setAnalyticsCookie('browse|italian')" title="Italian Recipes" target="_self">Italian</a>
                                </li>
                                <li>
                                    <a href="/recipes/728/world-cuisine/latin-american/mexican/" ng-click="setAnalyticsCookie('browse|mexican')" title="Mexican Recipes" target="_self">Mexican</a>
                                </li>
                                <li>
                                    <a href="/recipes/15876/us-recipes/southern/" ng-click="setAnalyticsCookie('browse|southern')" title="Southern Recipes" target="_self">Southern</a>
                                </li>
                            </ul>
                        </li>
                        <li class="item-category">
                            <h3>Special Collections</h3>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <ul class="list-unstyled sub-categories-list">
                                <li>
                                    <a href="http://allrecipes.com/recipes/17235/everyday-cooking/allrecipes-magazine-recipes/" ng-click="setAnalyticsCookie('browse|allrecipes magazine recipes')" title="Allrecipes Magazine Recipes" target="_self">Allrecipes Magazine Recipes</a>
                                </li>
                                <li>
                                    <a href="http://allrecipes.com/recipes/16791/everyday-cooking/special-collections/web-show-recipes/food-wishes/" ng-click="setAnalyticsCookie('browse|food wishes with chef john')" title="Food Wishes with Chef John Recipes" target="_self">Food Wishes with Chef John</a>
                                </li>
                                <li>
                                    <a href="http://dish.allrecipes.com/trusted-brand-pages/" ng-click="setAnalyticsCookie('browse|trusted brands')" title="Trusted Brands Recipes" target="_self">Trusted Brands</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="all-categories-link">
                        <div class="recipe-hero-link__item__text">All Categories</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</nav>
<!-- end header