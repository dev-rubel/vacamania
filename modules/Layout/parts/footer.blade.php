<div class="bravo_footer">
    <div class="mailchimp">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-10 col-lg-offset-1">
                    <div class="row">
                        <div class="col-xs-12  col-md-7 col-lg-6">
                            <div class="media ">
                                <div class="media-left hidden-xs">
                                    <img class="media-object"
                                     src="https://vacamania.com/uploads/0000/1/2020/01/08/nwload-app.png"
                                     alt="">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{__("COMPANY")}}</h4>
                                    <p class="f14"><a href="https://vacamania.com/page/about-us" class="st-link">About Us</a></p>
								 <p class="f14"><a href="https://vacamania.com/en/page/terms-and-conditions" class="st-link">Terms of Service</a></p>
								  <p class="f14"><a href="https://vacamania.com/en/page/travel-insurance" class="st-link">Travel Insurance</a></p>
								   <p class="f14"><a href="https://vacamania.com/contact" class="st-link">Contact Us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-5 col-lg-6">
						<div class="media ">
						<div class="media-body">
                            <h4 class="media-heading">{{__("PARTNERSHIP")}}</h4>
                                    <p class="f14"><a href="https://vacamania.com/page/become-a-vendor" class="st-link">Travel Agency</a></p>
								 <p class="f14"><a href="https://vacamania.com/en/page/terms-and-conditions" class="st-link">T&S Partner</a></p>
								  <p class="f14"><a href="#" class="st-link"></a></p>
								   <p class="f14"><a href="#" class="st-link"></a></p>
                          </div>								   
						<div class="media-body">						          
								 <form action="{{route('newsletter.subscribe')}}" class="subcribe-form bravo-subscribe-form bravo-form">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control email-input" placeholder="{{__('Your Email')}}">
                                    <button type="submit" class="btn-submit">{{__('Subscribe')}}
                                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </button>
                                </div>
                                <div class="form-mess"></div>
                            </form>  
                        </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="main-footer">
        <div class="container">
            <div class="row">
                @if($list_widget_footers = setting_item_with_lang("list_widget_footer"))
                    <?php $list_widget_footers = json_decode($list_widget_footers); ?>
                    @foreach($list_widget_footers as $key=>$item)
                        <div class="col-lg-{{$item->size ?? '3'}} col-md-6">
                            <div class="nav-footer">
                                <div class="title">
                                    {{$item->title}}
                                </div>
                                <div class="context">
                                    {!! $item->content  !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="copy-right">
        <div class="container context">
            <div class="row">
                <div class="col-md-12">
                    {!! setting_item_with_lang("footer_text_left") ?? ''  !!}
                    <div class="f-visa">
                        {!! setting_item_with_lang("footer_text_right") ?? ''  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Layout::parts.login-register-modal')
@include('Layout::parts.chat')
@if(Auth::id())
    @include('Media::browser')
@endif
<link rel="stylesheet" href="{{asset('libs/flags/css/flag-icon.min.css')}}" >

{!! \App\Helpers\Assets::css(true) !!}

{{--Lazy Load--}}
<script src="{{asset('libs/lazy-load/intersection-observer.js')}}"></script>
<script async src="{{asset('libs/lazy-load/lazyload.min.js')}}"></script>
<script>
    // Set the options to make LazyLoad self-initialize
    window.lazyLoadOptions = {
        elements_selector: ".lazy",
        // ... more custom settings?
    };

    // Listen to the initialization event and get the instance of LazyLoad
    window.addEventListener('LazyLoad::Initialized', function (event) {
        window.lazyLoadInstance = event.detail.instance;
    }, false);


</script>
<script src="{{ asset('libs/lodash.min.js') }}"></script>
<script src="{{ asset('libs/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('libs/vue/vue.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>
@if(Auth::id())
    <script src="{{ asset('module/media/js/browser.js?_ver='.config('app.version')) }}"></script>
@endif
<script src="{{ asset('libs/carousel-2/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset("libs/daterange/moment.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("libs/daterange/daterangepicker.min.js") }}"></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}" ></script>
<script src="{{ asset('js/functions.js?_ver='.config('app.version')) }}"></script>

@if(setting_item('inbox_enable'))
    <script src="{{ asset('module/core/js/chat-engine.js?_ver='.config('app.version')) }}"></script>
@endif
<script src="{{ asset('js/home.js?_ver='.config('app.version')) }}"></script>

@if(!empty($is_user_page))
    <script src="{{ asset('module/user/js/user.js?_ver='.config('app.version')) }}"></script>
@endif

{!! \App\Helpers\Assets::js(true) !!}

@yield('footer')

@php \App\Helpers\ReCaptchaEngine::scripts() @endphp