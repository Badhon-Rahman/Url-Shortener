@include('layouts.admin.admin')
<link rel="stylesheet" href="{{ asset('css/urls.css') }}">

<main style="text-align: center;">
        <!-- Page Heading -->
    <header class="bg-white shadow" style="text-align:center;">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> 
            <strong>Create New Shortern Url</strong>
        </div>
    </header>
    <div >
        <br>
        
        <form style="display: inline-block;width:63%;" method="POST" action="{{ route('urlShortener') }}">
            @csrf

            <!-- Uniform Resource Locator -->
            <div>
                <x-label for="url" :value="__('URL(Uniform Resource Locator)')" />

                <x-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required autofocus />
            </div>

            <!-- Expiration Time -->
            <div class="mt-4">
                <x-label for="expirationTime" :value="__('Expiration Time')" />
                <input type="datetime-local" id="expirationTime"
                    name="expiration_time" value="<?php echo date('Y-m-d h:m');?>"
                    min="<?php echo date('Y-m-d h:m');?>" max="2100-06-14T00:00">
            </div>

            <div class="mt-4">
                <p>Select your link type:</p>
                <input type="radio" id="Private" name="linkType" value="Private">
                <label for="Private">Private</label><br>
                <input type="radio" id="Public" name="linkType" value="Public">
                <label for="Public">Public</label><br>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4 btn-info" style="background-color:#4267B2;">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>      
    </div>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $.toaster({ priority :'success', title :'Title', message :'Your message here'});
      </script>
</main>
