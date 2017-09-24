<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Config;
use RoboPlanner\Helper\AesTrait;
use RoboPlanner\Repositories\PageRepository;
use RoboPlanner\Repositories\PostRepository;
use RoboPlanner\Repositories\CategoryRepository;
use RoboPlanner\Repositories\UserRepository;
use RoboPlanner\Repositories\UserMetaRepository;
use Response;
use RoboPlanner\Repositories\SettingRepository;
use App\Page;
use App\Post;
use App\Ticker;
use App\USStock;
use Carbon\Carbon;
class HomeController extends Controller
{
    use AesTrait;

    public function __construct(Request $request, UserRepository $user, UserMetaRepository $user_meta, SettingRepository $setting, PageRepository $page, PostRepository $post, CategoryRepository $category)
    {
        $this->request  = $request;
        $this->user     = $user;
        $this->user_meta= $user_meta;
        $this->setting  = $setting;
        $this->page     = $page;
        $this->post     = $post;
        $this->category = $category;
    }


    public function index(){
//        print_r(config('app.locales')) ;
//        return config('app.locales.en');
//        dd(config('app.locales'));
//        $data['menus'] = $this->page->getMenu($this->request, 0);
        return view('frontend.home');
    }

    public function getPage($slug = null){
        $page           = Page::where('slug', $slug)->first();

        $data['page']   = $page;
        if(isset($page->status) && $page->status == 'published')
        {
            return view('frontend.single_column',$data);
        }
        else{
            return view('roboplanner.errors.403');
        }
    }

    public function getPost($slug = null){
        $post           = Post::where('slug', $slug)->first();
      #dd($post);
        $data['post']   = $post;
        if(isset($post->status) && $post->status == 'Publish')
        // if($post->status == 'publish')
        {
            return view('frontend.blog_post',$data);
        }
        else{
            return view('roboplanner.errors.403');
        }
    }

    public function signup(){

        $data = [];
        $data = ['symbols' => $this->setting->getSymbols()];
        $data['menus'] = $this->page->getMenu($this->request, 0);
        return view('frontend.signup',$data);
    }

    public function signin(){
        if(Auth::user())
        {
            return redirect()->route('users');
        }

        $data['menus'] = $this->page->getMenu($this->request, 0);
        // return view('frontend.signin');
        return view('auth.login', $data);
    }

    public function preview_investment_secret(){
        $filename = 'investment-secrets.pdf';
        $path = storage_path('pdf/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
    public function bear_market_survival(){
        $filename = 'bear-market-survival.pdf';
        $path = storage_path('pdf/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
    public function protecting_your_asset(){
        $filename = 'protecting-your-asset.pdf';
        $path = storage_path('pdf/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
    public function social_security_guide(){
        $filename = 'social-security-guide.pdf';
        $path = storage_path('pdf/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
    public function the_mutual_fund(){
        $filename = 'the-mutual-fund.pdf';
        $path = storage_path('pdf/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

    public function videos()
    {
        // return view('frontend.resources.videos');
        return redirect('https://www.youtube.com/channel/UCGL57pJkjglZSy-ApIfWpHw');
    }

    public function blog(Request $request)
    {
        $data['posts']       = $this->post->getPost($request, true);
        $data['archive']    = $this->post->archive();
        $data['category']   = $this->category->getAllCategories();
        return view('frontend.blog',$data);
    }

    public function blogCategory(Request $request, $slug){
        $data['posts']       = $this->post->getCategoryPost($slug);
        $data['category']   = $this->category->getCategories($request);
        $data['archive']    = $this->post->archive();
        return view('frontend.blog',$data);
    }

    public function blogArchive(Request $request, $slug){
        $data['posts']       = $this->post->getArchive($slug);
        $data['category']   = $this->category->getCategories($request);
        $data['archive']    = $this->post->archive();
        return view('frontend.blog',$data);
    }

    public function getBlogPost(Request $request, $slug){
        $data['category']   = $this->category->getCategories($request);
        $data['archive']    = $this->post->archive();
        $data['post']       = $this->post->getBlogPost($slug);
        return view('frontend.blog_post',$data);
    }

    public function tempSave(Request $request){
        $input              = $request->all();
//        if(isset($input['child'])){
//            $b = serialize($input['child']);
//            echo  $b . "<br>" . print_r(unserialize($b));
////            return;
//        }

        $result             = $this->user->checkEmail($input['email']);

        if($result['status'] == 0){
            return response()->json($result);
        }

        session('fields', $input);
        session('step', $input['step']);
        return response()->json($result);

    }

    /**
     * Saving Signup form data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signupSave(Request $request){
        $input      = $request->except(['_token']);
        $user       = $this->user->signupSave($input);
        if($user){
            $this->user->assign_role(2, $user->id);

//            $this->user_meta->signupSave($user->id,$input);
            return response()->json(['status' => 1, 'message' => 'Signup Successful']);
        }

        return response()->json(['status' => 0, 'messagen bn    ' => 'You signup is not successful!!']);
//        return redirect()->route('home');
    }

    /**
     * if signup passed this method will be call from repository class listener
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passed(){
       return redirect()->route('success')->with('status', 'Success');
     }

     /**
     * if signup failed, this method will be call from repository class listener
     * @param $validator
     * @return $this
     */
    public function failed($validator){
        return redirect()->route('signup', ['error'])->withErrors($validator)->withInput();
    }

    public function ajaxPassed(){
        return response()->json(['status' => 1, 'message' => $this->ajax_message]);
    }

    public function ajaxFail(){
        return response()->json(['status' => 0, 'message' => $this->ajax_message]);
    }

    public function ajaxResults(){
        return response()->json($this->ajax_results);
    }

    public function validateEmail(Request $request){
        return response()->json($this->user->checkEmail($request->email));
    }

    public function SignUpSuccess(){
        return view('frontend.welcome');
    }

    public function auth(Request $request)
    {
        $email      = trim($request->email);
        $password   = trim($request->password);
        $remember   = $request->remember;


        $checkemail = $this->user->checkEmail($email);
        if($checkemail['status'] == 0) return redirect()->back()->with('error', 'Your email does not exist!');


        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 'Active'], $remember))
        {
            session_start();
            $accesskey              = $this->generateRandomString(50);
//            $_SESSION["ACCESS_KEY"]  = $accesskey;
            session(['ACCESS_KEY' => $accesskey]);
            $_SESSION["ACCESS_KEY"] = session('ACCESS_KEY');
            return redirect()->route('dashboard');
//            if(Auth::user()->hasRole('administrator'))
//            {
//                return redirect()->route('dashboard');
//            }

        }
        else
        {
            return redirect()->back()->withInput()->with('error', 'Invalid password!');
        }
    }

    public function logout()
    {
        session_start();
        session()->forget('ACCESS_KEY');
        unset($_SESSION["ACCESS_KEY"]);
        Auth::logout();
        
        return redirect()->route('login');
    }

    private function generateRandomString($length = 50) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    //for updated list of Symbols
    public function ticker(){
        Ticker::truncate();
        // return redirect('https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?date=20160912&qopts.columns=ticker&api_key=W11_2Viqa-YrP9oPzSVy');
        $url = "https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?date=20160912&qopts.columns=ticker&api_key=W11_2Viqa-YrP9oPzSVy";
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        $datatable = $json_data['datatable'];
        $data      = $datatable['data'];
        foreach ($data as $key) {
            $ticker = new Ticker;
            $ticker->symbol = $key[0];
            $ticker->save();
        }
    }
    
    public function first_run(){
        #Ticker::truncate();
        $ticker = Ticker::where('first_run','false')->get();
        $i = 1;
        $now = Carbon::now();
        $date_now = $now->format('Ymd');
       foreach ($ticker as $key => $value){
            $ticker = $value->symbol;
            //$url = "https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?date=20160912&qopts.columns=ticker,date,close&api_key=W11_2Viqa-YrP9oPzSVy";
            $url  = 'https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?&date.gt=199001001&date.lte=20170310&ticker='. $ticker .'&qopts.columns=ticker,date,close&api_key=W11_2Viqa-YrP9oPzSVy';
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);
            $datatable = $json_data['datatable'];
            $data      = $datatable['data'];
            // dd($data);
            $us_stock = new USStock;
            $us_stock->symbol = $ticker;
            $us_stock->details =json_encode($data);
            $us_stock->save();
            if($i++ == 10) break;
        }

        $us_stock = USStock::get();
        foreach ($us_stock as $key => $value) {
           $us_stock_symbol = $value['symbol'];
           $ticker_symbol = Ticker::where('symbol', $us_stock_symbol)->first();
           $ticker_symbol->first_run = 'true';
           $ticker_symbol->save(); 
        }
    }

    //daily close of US Stocks per day per symbol
     public function daily_update(){
        #Ticker::truncate();
        $ticker = Ticker::where('first_run','true')->get();
        $i = 1;
        $now = Carbon::now();
        $date_now = $now->format('Ymd');
        foreach ($ticker as $key => $value) {
            $ticker = $value->symbol;
            $stock = USStock::where('symbol', $ticker)->first();

            //$last_update = $stock->updated_at->format('Ymd'); -----> original variable for last updated date

            $last_update = '20170310';
            $old_data = json_decode($stock->details);
            //$url = "https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?date=20160912&qopts.columns=ticker,date,close&api_key=W11_2Viqa-YrP9oPzSVy";
           // $url  = 'https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?&date.gt=1987%C2%AD01%C2%AD01&date.lte='. $date_now .'&ticker='. $ticker .'&qopts.columns=ticker,date,close&api_key=W11_2Viqa-YrP9oPzSVy';
            $url  = 'https://www.quandl.com/api/v3/datatables/WIKI/PRICES.json?&date.gt='.$last_update.'&date.lte='. $date_now .'&ticker='. $ticker .'&qopts.columns=ticker,date,close&api_key=W11_2Viqa-YrP9oPzSVy';
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);
            $datatable = $json_data['datatable'];
            $new_data  = $datatable['data'];
            // dd($data);
            $us_stock = USStock::where('symbol', $ticker)->first();;
            $us_stock->symbol = $ticker;
            $merge = array_merge($old_data, $new_data);
            $us_stock->details =json_encode($merge);
            $us_stock->save();
            // if($i++ == 10) break;
        }
    }

    public function fetch(Request $request){
        $query = USStock::where('symbol', $request->symbol)->first()->details;

        $us_stock = json_decode($query);
        $sum = 0;
        foreach ($us_stock as $key =>$value) {
            $sum += $value[2];
        }
        //count of stocks
        $us_stock_count = count($us_stock);
        //average of each stocks
        $average = number_format(($sum / $us_stock_count), 2, '.', '');
        dd($us_stock_count, $average, $us_stock);
    }
}

