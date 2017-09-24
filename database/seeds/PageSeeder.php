<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
       		[
       			'title' 	 => 'Why Us',
            'parent_id'=> '0',
       			'slug'		 => 'why-us',
    				'content'  => '',
    				'status'   => 'published',
    				'template' => 'single_column',
    				'order'    => '1',
       		],
       		[
       			'title' 	=> 'Pricing',
            'parent_id'=> '0',
       			'slug'		=> 'pricing',
    				'content' => '',
    				'status'  => 'published',
    				'template'=> 'single_column',
    				'order'   => '3',
       		],
       		[
       			'title' 	=> 'Knowledge Center',
            'parent_id'=> '0',
       			'slug'		=> 'knowledge-center',
    				'content' => '',
    				'status'  => 'published',
    				'template'=> 'single_column',
    				'order'   => '2',
       		],
          [
            'title'   => 'Security',
            'parent_id'=> '1',
            'slug'    => 'why-us/security',
            'content' => '<div class="banner overview sub-banner-background">
                          <div class="row">
                          <div class="col-sm-12 description">
                          <h1>orem ipsum dolor sit amet ipsum dololor sit ipsum <br /> Security</h1>
                          </div>
                          </div>
                          </div>
                          <div class="container">
                          <div class="row box-padding">
                          <div class="col-sm-3">
                          <div class="content-box image-center">
                          <div class="row">
                          <div class="image-center"><img src="/source/bulb.png?1474619583548" alt="" width="48" height="74" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Consectetuer Adipiscing</h3>
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474619599775" alt="" width="20" height="20" /></div>
                          <div id="content" class="row" style="display: none;"><hr />
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="col-sm-3">
                          <div class="content-box image-center">
                          <div class="row">
                          <div class="image-center"><img src="/source/clock.png?1474619624185" alt="" width="74" height="74" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Consectetuer Adipiscing</h3>
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474619613003" alt="" width="20" height="20" /></div>
                          <div id="content" class="row" style="display: none;"><hr />
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="col-sm-3">
                          <div class="content-box image-center">
                          <div class="row">
                          <div class="image-center"><img src="/source/globe.png?1474619635008" alt="" width="74" height="74" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Consectetuer Adipiscing</h3>
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474619644573" alt="" width="20" height="20" /></div>
                          <div id="content" class="row" style="display: none;"><hr />
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="col-sm-3">
                          <div class="content-box image-center">
                          <div class="row">
                          <div class="image-center"><img src="/source/bulb.png?1474619666595" alt="" width="48" height="74" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Consectetuer Adipiscing</h3>
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474619676976" alt="" width="20" height="20" /></div>
                          <div id="content" class="row" style="display: none;"><hr />
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="row row-box">
                          <div class="col-sm-6">
                          <h1>Ipsum dolor sit amet ipsum</h1>
                          <p style="text-align: justify;">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
                          <button class="btn  btn-primary pull-right"> READ MORE</button></div>
                          <div class="col-sm-6">
                          <h1>Ipsum dolor sit amet ipsum</h1>
                          <p style="text-align: justify;">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
                          <button class="btn  btn-primary pull-right"> READ MORE</button></div>
                          </div>
                          </div>
                          <div class="river sub-banner banner-text">
                          <div class="col-sm-2">&nbsp;</div>
                          <div class="col-sm-8 top">
                          <p class="big-title white-font shadow">Ipsum dolor sit amet ipsum laoreet. Quisque elementum eget mi non mattis</p>
                          </div>
                          <div class="col-sm-2">&nbsp;</div>
                          </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '1',
          ],
          [
            'title'   => 'The Truvize Advantage',
            'parent_id'=> '1',
            'slug'    => 'why-us/the-truvize-advantage',
            'content' => '<div class="banner overview sub-banner-background">
                        <div class="row">
                        <div class="col-sm-12 description">
                        <h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum <br />Portfolio</h1>
                        </div>
                        </div>
                        </div>
                        <div class="container">
                        <div class="row row-box">
                        <div class="col-sm-6">
                        <h1>Portfolio</h1>
                        <p>Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
                        </div>
                        <div class="col-sm-6"><img src="http://placehold.it/700x293" alt="" /></div>
                        </div>
                        <hr />
                        <div class="row center-title">
                        <div class="col-sm-12 box-padding">
                        <div class="row">
                        <h1>Lorem ipsum dolor sit amet, Etiam rutrum nisi euuris nulla</h1>
                        </div>
                        <div class="row">
                        <div class="col-sm-3 box-padding round-holder">
                        <div class="row">
                        <div class="round-small image-center"><img src="/source/home_finance_offer_icon_2.png?1474619815901" alt="" width="220" height="204" /></div>
                        </div>
                        <div class="row">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
                        <button class="btn btn-primary">Read More &gt;&gt;</button></div>
                        </div>
                        <div class="col-sm-3 box-padding round-holder">
                        <div class="row">
                        <div class="round-small image-center"><img src="/source/bank_2.png?1474619845369" alt="" width="802" height="639" /></div>
                        </div>
                        <div class="row">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
                        <button class="btn btn-primary">Read More &gt;&gt;</button></div>
                        </div>
                        <div class="col-sm-3 box-padding round-holder">
                        <div class="row">
                        <div class="round-small image-center"><img src="/source/Bar-graph-arrow-2.png?1474619862415" alt="" width="644" height="684" /></div>
                        </div>
                        <div class="row">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
                        <button class="btn btn-primary">Read More &gt;&gt;</button></div>
                        </div>
                        <div class="col-sm-3 box-padding round-holder">
                        <div class="row">
                        <div class="round-small image-center"><img src="/source/money-bag-2.png?1474619876291" alt="" width="159" height="221" /></div>
                        </div>
                        <div class="row">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
                        <button class="btn btn-primary">Read More &gt;&gt;</button></div>
                        </div>
                        </div>
                        </div>
                        </div>
                        <hr />
                        <div class="row box-padding">
                        <div class="col-sm-12 center-title">
                        <h1>Quisque elementum eget mi non mattis. Interdum et malesuada fames</h1>
                        <h3>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</h3>
                        </div>
                        </div>
                        </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '2',
          ],
          [
            'title'   => 'Our Investment Edge',
            'parent_id'=> '1',
            'slug'    => 'why-us/our-investment-edge',
            'content' => '<div class="banner overview sub-banner-background">
                        <div class="row">
                        <div class="col-sm-12 description">
                        <h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum <br /> Overview</h1>
                        </div>
                        </div>
                        </div>
                        <div class="container">
                        <div class="row row-box">
                        <div class="col-sm-6"><img src="http://placehold.it/479x293" alt="" /></div>
                        <div class="col-sm-6">
                        <h1>Overview</h1>
                        <p>Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
                        <br />
                        <h3>Overview</h3>
                        <p>Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero,</p>
                        </div>
                        </div>
                        </div>
                        <div class="container-fluid">
                        <div class="row computer-background sub-banner banner-text row-shadow">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8 top">
                        <p class="big-title white-font shadow">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis</p>
                        </div>
                        <div class="col-sm-2">&nbsp;</div>
                        </div>
                        </div>
                        <div class="container">
                        <div class="row row-box">
                        <div class="col-sm-6">
                        <h1>Overview</h1>
                        <p>Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
                        <br />
                        <h3>Overview</h3>
                        <p>Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero,</p>
                        </div>
                        <div class="col-sm-6"><img src="http://placehold.it/479x293" alt="" /></div>
                        </div>
                        </div>
                        <div class="container-fluid">
                        <div class="row blue-background row-shadow text-center">
                        <div class="col-sm-12 box-padding white-font">
                        <div class="row">
                        <h1>Lorem ipsum dolor sit amet, Etiam rutrum nisi euuris nulla</h1>
                        </div>
                        <div class="row">
                        <div class="col-sm-4 box-padding">
                        <div class="row">&nbsp;</div>
                        <div class="row">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
                        </div>
                        </div>
                        <div class="col-sm-4 box-padding">
                        <div class="row">&nbsp;</div>
                        <div class="row">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
                        </div>
                        </div>
                        <div class="col-sm-4 box-padding">
                        <div class="row">&nbsp;</div>
                        <div class="row">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</p>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="container">
                        <div class="row box-padding">
                        <div class="col-sm-12 center-title">
                        <h1>Quisque elementum eget mi non mattis. Interdum et malesuada fames</h1>
                        <h3>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</h3>
                        </div>
                        </div>
                        <hr />
                        <div class="row box-padding center-title">
                        <div class="col-sm-3">
                        <div class="round"><img src="/source/default_user.png?1474620006633" alt="" width="225" height="225" /></div>
                        <p>FirstName LastName</p>
                        <cite>Position</cite></div>
                        <div class="col-sm-3">
                        <div class="round"><img src="/source/default_user.png?1474620022035" alt="" width="225" height="225" /></div>
                        <p>FirstName LastName</p>
                        <cite>Position</cite></div>
                        <div class="col-sm-3">
                        <div class="round"><img src="/source/default_user.png?1474620057856" alt="" width="225" height="225" /></div>
                        <p>FirstName LastName</p>
                        <cite>Position</cite></div>
                        <div class="col-sm-3">
                        <div class="round"><img src="/source/default_user.png?1474620069110" alt="" width="225" height="225" /></div>
                        <p>FirstName LastName</p>
                        <cite>Position</cite></div>
                        </div>
                        </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '3',
          ],
          [
            'title'   => 'Compare to Our Competitiors',
            'parent_id'=> '1',
            'slug'    => 'why-us/compare-to-our-competitors',
            'content' => '<div class="banner overview sub-banner-background">
                          <div class="row">
                          <div class="col-sm-12 description">
                          <h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum <br />Tax Efficient Investing</h1>
                          </div>
                          </div>
                          </div>
                          <div class="container">
                          <div class="row">
                          <div class="col-sm-12">
                          <h2 class="text-center">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h2>
                          </div>
                          </div>
                          <div class="row box-padding">
                          <div class="col-sm-4">
                          <div class="content-box">
                          <div class="row">
                          <div class="image-center"><img src="/source/bulb.png?1474616997515" alt="" width="48" height="74" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Consectetuer Adipiscing</h3>
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          </div>
                          </div>
                          <div class="col-sm-4">
                          <div class="content-box">
                          <div class="row">
                          <div class="image-center"><img src="/source/clock.png?1474617635172" alt="" width="74" height="74" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Consectetuer Adipiscing</h3>
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          </div>
                          </div>
                          <div class="col-sm-4">
                          <div class="content-box">
                          <div class="row">
                          <div class="image-center"><img src="/source/globe.png?1474617658251" alt="" width="74" height="74" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Consectetuer Adipiscing</h3>
                          <p>Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit</p>
                          </div>
                          </div>
                          </div>
                          </div>
                          <hr />
                          <div class="row box-padding">
                          <div class="row">
                          <div class="col-sm-6">
                          <h1>Tax Efficient Investing</h1>
                          </div>
                          <div class="col-sm-6">&nbsp;</div>
                          </div>
                          <div class="row">
                          <div class="col-sm-6">
                          <div class="row">
                          <div class="col-sm-12"><img style="float: left; width: 100%;" src="http://placehold.it/479x300" alt="" /></div>
                          </div>
                          <div class="row">
                          <div class="col-sm-12 text-center">
                          <p class="sub-title">Ipsum dolor sit ipsum dololor</p>
                          <p style="font-size: 20px;">Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit.</p>
                          </div>
                          </div>
                          </div>
                          <div class="col-sm-6">
                          <div class="row">
                          <div class="col-sm-12"><img style="float: left; width: 100%;" src="http://placehold.it/479x300" alt="" /></div>
                          </div>
                          <div class="row">
                          <div class="col-sm-12 text-center">
                          <p class="sub-title">Ipsum dolor sit ipsum dololor</p>
                          <p style="font-size: 20px;">Ipsum dolor sit amet ipsum dololor sit ipsum. dolor sit olor sit ipsum doltetuer adipiscing elit.</p>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="container-fluid">
                          <div class="row river sub-banner banner-text row-shadow">
                          <div class="col-sm-2">&nbsp;</div>
                          <div class="col-sm-8 top">
                          <p class="big-title white-font shadow">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis</p>
                          <button class="btn btn-primary">READ MORE</button></div>
                          <div class="col-sm-2">&nbsp;</div>
                          </div>
                          <div class="row box-padding">
                          <div class="col-sm-12 center-title">
                          <h1>Quisque elementum eget mi non mattis. Interdum et malesuada fames</h1>
                          <h3>Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero</h3>
                          </div>
                          </div>
                          </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '4',
          ],
          [
            'title'   => 'Blog',
            'parent_id'=> '3',
            'slug'    => 'knowledge-center/blog',
            'content' => '<div class="row row-box">
                          <div class="col-sm-6">
                            <h1>Ipsum dolor sit amet ipsum </h1>
                            <p style="text-align:justify">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
                            <button class="btn  btn-primary pull-right"> READ MORE</button>
                          </div>
                          <div class="col-sm-6">
                            <h1>Ipsum dolor sit amet ipsum </h1>
                            <p style="text-align:justify">Curabitur at neque vel nunc rutrum laoreet. Quisque elementum eget mi non mattis. Interdum et malesuada fames ac ante ipsum primis in faucibus.Donec egestas nisl aliquam libero tempor vulputate. Etiam rutrum, nisi eu condimentum venenatis, mauris nulla ullamcorper libero, non dignissim ipsum leo in lectus.</p>
                            <button class="btn  btn-primary pull-right"> READ MORE</button>
                          </div>
                        </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '1',
          ],
          [
            'title'   => 'Videos',
            'parent_id'=> '3',
            'slug'    => 'knowledge-center/videos',
            'content' => '',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '2',
          ],
          [
            'title'   => 'Webinars',
            'parent_id'=> '3',
            'slug'    => 'knowledge-center/webinars',
            'content' => '<div class="banner overview sub-banner-background">
                        <div class="row">
                        <div class="col-sm-12 description">
                        <h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum <br /> Webinar</h1>
                        </div>
                        </div>
                        </div>
                        <div class="container">
                        <div class="row">
                        <div class="col-sm-6" style="padding: 30px 50px 30px 50px;">
                        <div class="row">
                        <h1>The Latest Webinars</h1>
                        </div>
                        <div class="row"><iframe src="https://www.youtube.com/embed/zui6xUrztFs" width="100%" height="500px" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
                        <div class="row">
                        <h2 class="text-center" style="padding: 0 50px 0 50px;">The Fox River Wealth Wheel Introductory Webinar</h2>
                        <div class="horizontal-line">&nbsp;</div>
                        <p style="min-height: 160px;">The Wealth Wheel is a concept developed by the Fox River Capital team to act as a comprehensive guide to help families through the lifecycle of their financial careers. Many families think they have a comprehensive financial plan when all they truly have is a set of tactics. Gain peace of mind today by watching and implementing the Wealth Wheel.</p>
                        </div>
                        <div class="row">
                        <h2>Interested in dominating your finances?</h2>
                        <cite>What if making one simple hour, one simple decision could change the trajectory of your financial life? Are you bold enough to make that decision? You tell me.</cite> <br /> <br /> <button class="btn btn-primary" data-toggle="modal" data-target="#form">It\'s Time for a Change</button></div>
                        <!-- Modal -->
                        <div id="form" class="modal fade">
                        <div class="modal-dialog"><!-- Modal content-->
                        <div class="modal-content blue-background" style="padding: 20px 40px 20px 40px;">
                        <div class="modal-header"><button class="close" type="button" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title text-center white-font">Let\'s Get in Touch</h2>
                        </div>
                        <div class="modal-body"><form style="padding: 20px;"><input class="form-control" type="text" value="" placeholder="Name" /><br /> <input class="form-control" type="text" value="" placeholder="Email" /></form></div>
                        <div class="modal-footer"><button class="btn btn-warning" type="button" data-dismiss="modal">CANCEL</button> <input class="btn btn-subscribe square" type="submit" value="SEND" /></div>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="col-sm-6" style="padding: 30px 50px 30px 50px;">
                        <div class="row">
                        <h1>College Planning Webinars</h1>
                        </div>
                        <div class="row"><iframe src="https://www.youtube.com/embed/-3f8-XRHfSc" width="100%" height="500px" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
                        <div class="row">
                        <h2 class="text-center" style="padding: 0 50px 0 50px;">The College Funding Blueprint Webinar</h2>
                        <div class="horizontal-line">&nbsp;</div>
                        <p style="min-height: 160px;">The College Funding Blueprint is a book written by Fox River Capital\'s Director of College Planning, Eric Sajdak ChFC&reg;. This webinar goes through each section of the book explaining key points and concepts. It shows strategies for maximizing your child\'s financial aid package, graduating debt-free, and stretching your family\'s dollar the furthest. All of things work in unison to help may college your \'s greatest investment!</p>
                        </div>
                        <div class="row">
                        <h2>I Want to Dominate College</h2>
                        <cite>I want to my family to leave college debt free. I want it to be my family\'s best investment. College is one of my biggest headaches and that needs to change.</cite> <br /> <br /> <button class="btn btn-primary" data-toggle="modal" data-target="#form">It\'s Time for a Change</button></div>
                        </div>
                        </div>
                        </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '3',
          ],
          [
            'title'   => 'Whitepapers',
            'parent_id'=> '3',
            'slug'    => 'knowledge-center/whitepapers',
            'content' => '<div class="banner overview sub-banner-background">
                          <div class="row">
                          <div class="col-sm-12 description">
                          <h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum <br /> White Paper</h1>
                          </div>
                          </div>
                          </div>
                          <div class="container">
                          <div class="row">
                          <div class="col-sm-12 text-center">
                          <h2>Our Latest Whitepapers</h2>
                          </div>
                          </div>
                          <div id="book" class="row box-padding">
                          <div class="col-sm-4">
                          <div class="content-box image-center faid-in-left">
                          <div class="row">
                          <div class="image-center"><img src="/source/investment_secrets_of_the_wealthy.png?1474618054520" alt="" width="214" height="277" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Investment Secrets of the Wealthy</h3>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474618104624" alt="" width="20" height="20" /><br /><hr /></div>
                          <div id="content" class="row" style="display: none;">
                          <p>The Investment Secrets socof the Wealthy is all about decoding the habits and secrets of the world\'s best investors. In this whitepaper we discuss concepts like strategic diversification, how to profit in bear markets, and how to unhitch your investments from the crowd. If you\'re an investor, this guide is a must for achieving investment success.</p>
                          </div>
                          </div>
                          </div>
                          <div class="row"><a href="/portal/page/edit/{{ route(\'preview_investment_secret\')}}" target="_blank"> <button class="btn btn-primary">VIEW PDF </button> </a> <a href="//storage.googleapis.com/instapage-user-media/8b404141/7146653-0-Investment-Secrets-o.pdf" target="_blank"> <button class="btn btn-success">DOWNLOAD PDF </button> </a></div>
                          </div>
                          </div>
                          <div class="col-sm-4">
                          <div class="content-box image-center fade-in">
                          <div class="row">
                          <div class="image-center"><img src="/source/social_security_guide.png?1474618139638" alt="" width="217" height="282" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">Social Security Guide</h3>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474618152524" alt="" width="20" height="20" /><br /><hr /></div>
                          <div id="content" class="row" style="display: none;">
                          <p>Think Social Security is broke? Think again. This guide dives deep into one of your largest assets in retirement and explores how you can recieve the highest benefit from Social Security. Timing Social Security properly could mean a 76% higher benefit each and every year for the rest of your life.</p>
                          </div>
                          </div>
                          </div>
                          <div class="row"><a href="/portal/page/edit/{{ route(\'social_security_guide\')}}" target="_blank"> <button class="btn btn-primary">VIEW PDF </button> </a> <a href="//storage.googleapis.com/instapage-user-media/8b404141/7146128-0-social-security-guid.pdf" target="_blank"> <button class="btn btn-success">DOWNLOAD PDF </button> </a></div>
                          </div>
                          </div>
                          <div class="col-sm-4">
                          <div class="content-box image-center faid-in-right">
                          <div class="row">
                          <div class="image-center"><img src="/source/the_mutual_fund_fantasy.png?1474618169619" alt="" width="219" height="282" /></div>
                          </div>
                          <div class="row">
                          <h3 class="text-center">The Mutual Fund Fantasy</h3>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474618182006" alt="" width="20" height="20" /><br /><hr /></div>
                          <div id="content" class="row" style="display: none;">
                          <p>The Mutual Fund Fantasy was written to expose the unfortunate reality of investing in mutual funds. High fees, poor performance, and investor deception define an overwhelming number of mutual funds. If you\'re an investor that is investing in mutual funds, have invested in them, or are debating about investing, this is a must-read.</p>
                          </div>
                          </div>
                          </div>
                          <div class="row"><a href="/portal/page/edit/{{ route(\'the_mutual_fund\')}}" target="_blank"> <button class="btn btn-primary">VIEW PDF </button> </a> <a href="//storage.googleapis.com/instapage-user-media/8b404141/7146168-0-The-Mutual-Fund-Fant.pdf" target="_blank"> <button class="btn btn-success">DOWNLOAD PDF </button> </a></div>
                          </div>
                          </div>
                          </div>
                          <div class="row">
                          <div class="col-sm-2">&nbsp;</div>
                          <div class="col-sm-4">
                          <div id="left" class="content-box image-center">
                          <div class="row">
                          <div class="image-center"><img src="/source/protecting_your_assets_from_the_nursing_home.png?1474618193997" alt="" width="219" height="282" /></div>
                          </div>
                          <div id="book" class="row">
                          <h3 class="text-center">Protecting Your Ass(ets) from the Nursing Home</h3>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474618205116" alt="" width="20" height="20" /><br /><hr /></div>
                          <div id="content" class="row" style="display: none;">
                          <p>With the cost of a private room in a nursing home being over $70,000 per year, long-term care has moved to being a top priority for retirees. The U.S. Government estimates that almost 70% of retirees will need some form of a long-term care at some point in life. If you have any interest in securing a safe retirement, this whitepaper on long-term care is for you.</p>
                          </div>
                          </div>
                          </div>
                          <div class="row"><a href="/portal/page/edit/{{ route(\'protecting_your_asset\')}}" target="_blank"> <button class="btn btn-primary">VIEW PDF </button> </a> <a href="//storage.googleapis.com/instapage-user-media/8b404141/7146143-0-protecting-your-ass-.pdf" target="_blank"> <button class="btn btn-success">DOWNLOAD PDF </button> </a></div>
                          </div>
                          </div>
                          <div class="col-sm-4">
                          <div id="right" class="content-box image-center">
                          <div class="row">
                          <div class="image-center"><img src="/source/the_bear_market_survival_guide.png?1474618217540" alt="" width="219" height="282" /></div>
                          </div>
                          <div id="book" class="row">
                          <h3 class="text-center">The Bear Market Survival <br />Guide</h3>
                          <div class="arrow">
                          <div class="row"><img src="/source/drop-down.png?1474618228076" alt="" width="20" height="20" /><br /><hr /></div>
                          <div id="content" class="row" style="display: none;">
                          <p>How did your portfolio handle the recession of \'08? What about the tech bubble of the early 2000\'s? If your like most investors, your portfolio didn\'t fare well. The reason? You haven\'t implemented the right tools and strategies to protect your portfolio. Download the Bear Market Survival guide today to learn how you can protect and profit from the next bear market. Yes, I said even profit.</p>
                          </div>
                          </div>
                          </div>
                          <div class="row"><a href="/portal/page/edit/{{ route(\'bear_market_survival\')}}" target="_blank"> <button class="btn btn-primary">VIEW PDF </button> </a> <a href="//storage.googleapis.com/instapage-user-media/8b404141/7146208-0-Bear-Market-Survival.pdf" target="_blank"> <button class="btn btn-success">DOWNLOAD PDF </button> </a></div>
                          </div>
                          </div>
                          <div class="col-sm-2">&nbsp;</div>
                          </div>
                          </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '4',
          ],
          [
            'title'   => 'Book',
            'parent_id'=> '3',
            'slug'    => 'knowledge-center/books',
            'content' => '<div class="banner book sub-banner-background">
                          <div class="row">
                          <div class="col-sm-12 description">
                          <h1>Lorem ipsum dolor sit amet ipsum dololor sit ipsum <br /> Book</h1>
                          </div>
                          </div>
                          </div>
                          <div class="container">
                          <div class="row">
                          <div class="col-sm-12 text-center">
                          <h1>Books Written by the <br />Fox River Capital Team</h1>
                          </div>
                          </div>
                          <div class="row row-box">
                          <div class="col-sm-4">
                          <div class="text-center">
                          <h2>The College Funding Blueprint</h2>
                          <div class="horizontal-line">&nbsp;</div>
                          <br /> <cite>By Eric Sajdak, ChFC&reg;</cite></div>
                          <p>The College Funding Blueprint is a result of asking one simple question, &ldquo;How would a family&rsquo;s financial situation change if there were able to make college a financial success rather than a financial burden?&rdquo; This book was created as the answer to that question. It is a collection of knowledge and wisdom from a nationally recognized financial team. Decades of research and experience went into discovering and implementing the concepts and strategies in this book.</p>
                          </div>
                          <div class="col-sm-4 image-center"><img src="/source/the_college_funding2.png?1474619243668" alt="" width="auto" height="400" /></div>
                          <div id="subscribe" class="col-sm-4 image-center"><form class="blue-background white-font" style="padding: 30px;"><label>Subscribe to be the First to Get Exclusive Access to the Knowledge Center</label> <cite>All subscribers will get access to the first 3 chapters of both Conversations that Count and The College Funding Blueprint! You will also become first in line and get notified of all up and coming webinars, new whitepapers, and much, much more. Subscribers will also get a special gift for subscribing! </cite><br /><br /> <label>Join the team today!</label> <input class="form-control" type="text" placeholder="Name" /><br /> <input class="form-control" type="text" placeholder="Email" /><br /><button class="btn btn-subscribe square">SEND</button></form></div>
                          </div>
                          </div>
                          <div class="container-fluid ">
                          <div class="row row-box" style="padding-left: 10%; padding-right: 10%;">
                          <div class="col-sm-4 image-center"><img src="/source/Eric-square.gif?1474619268111" alt="" width="200" height="auto" />
                          <h2 class="text-center">Author: Eric Sajdak, ChFC&reg;</h2>
                          <p>Eric Sajdak is a Partner at Fox River Capital and heads its college planning division. The experiences and situations that him and his team faced led to Eric writing this book to solve the college crisis that so many families are faced with. He has earned his Chartered Financial Consultant designation, ChFC&reg; from the American College.</p>
                          </div>
                          <div class="col-sm-4">
                          <h2>Inside the Book, You\'ll Learn:</h2>
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>How you can get a sale (discount) off your college bill</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>The conversion strategy so you can, "have your cake and eat it too"</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>A recent law change that will massively affect college planning</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>The fastest way to eliminate college debt</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>The most optimal college planning strategy</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>The Triple Deke Strategy</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>Ways you can get student loan debt forgiven</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>And much, much more.....</li>
                          </ul>
                          </ul>
                          </div>
                          </div>
                          </div>
                          <div class="container">
                          <div class="col-sm-8"><hr /></div>
                          <div class="col-sm-4">&nbsp;</div>
                          </div>
                          <div class="container">
                          <div class="row row-box">
                          <div class="col-sm-4">
                          <div class="text-center">
                          <h2>Conversations that Count</h2>
                          <div class="horizontal-line">&nbsp;</div>
                          <br /> <cite>By Tony Hellenbrand, RICP&reg;</cite></div>
                          <p>This is not a &ldquo;get rich quick&rdquo; book. This book is the result of over a decade spent managing investment portfolios for large institutions and high net worth investors from Scottsdale, AZ to Greenwich, CT and planning retirements for real clients in the real world. It is the distilled 20% of questions that yield 80% of results.</p>
                          </div>
                          <div class="col-sm-4 image-center"><img src="/source/conversations_that_count2.png?1474619323522" alt="" width="auto" height="400" /></div>
                          </div>
                          </div>
                          <div class="container-fluid">
                          <div class="row row-box" style="padding-left: 10%; padding-right: 10%;">
                          <div class="col-sm-4 image-center"><img src="/source/Tony-square.gif?1474619361673" alt="" width="200" height="auto" />
                          <h2 class="text-center">Author: Tony Hellenbrand, RICP&reg;</h2>
                          <p>Tony Hellenbrand is a Partner at Fox River Capital. Tony graduated from Michigan Technological University, where he studied finance. Tony\'s specialty is working with business owners and helping them plan for their succession, exit, and retirement. He has the Retirement Income Certified Professional, RICP&reg; designation from the American College. When the market&rsquo;s closed, Tony likes to shoot sporting clays, fish, and go to Packer and Badger Football games.</p>
                          </div>
                          <div class="col-sm-4">
                          <h2>Inside the Book, You\'ll Learn:</h2>
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>The only part of your financial plan you&rsquo;re 100% sure to use</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>How to save $1,200 in the next 12 months</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>How to get the most out of your largest retirement asset (that no one thinks of)</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>How to protect yourself from the government\'s "Nuclear" tax option</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>How to calculate the total costs of your investment portfolio</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>How to access your 401(k) before 59 1/2</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>Find out who your advisor is really working for</li>
                          </ul>
                          </ul>
                          <br />
                          <ul class="fa-ul">
                          <ul class="fa-ul">
                          <li>And much, much more.....</li>
                          </ul>
                          </ul>
                          </div>
                          <div id="subscribe2" class="col-sm-4 image-center"><form class="blue-background white-font" style="padding: 30px;"><label>Subscribe to be the First to Get Exclusive Access to the Knowledge Center</label> <cite>All subscribers will get access to the first 3 chapters of both Conversations that Count and The College Funding Blueprint! You will also become first in line and get notified of all up and coming webinars, new whitepapers, and much, much more. Subscribers will also get a special gift for subscribing! </cite><br /><br /> <label>Join the team today!</label> <input class="form-control" type="text" placeholder="Name" /><br /> <input class="form-control" type="text" placeholder="Email" /><br /><button class="btn btn-subscribe square">SEND</button></form></div>
                          </div>
                          </div>',
            'status'  => 'published',
            'template'=> 'single_column',
            'order'   => '5',
          ],
       	];
       foreach ($data as $key) {
       		DB::table('pages')->insert([
				'title'		=>	$key['title'],
        'parent_id'=>  $key['parent_id'], 	
				'slug'		=>	$key['slug'],	
				'content'	=>	$key['content'],	
				'status'	=>	$key['status'],	
				'template'	=>	$key['template'],	
				'order'		=>	$key['order'],
            ]);
       }
    }
}
