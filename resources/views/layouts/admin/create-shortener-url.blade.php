@include('layouts.admin.admin')

<main style="text-align: center;">
        <!-- Page Heading -->
    <header class="bg-white shadow" style="text-align:center;">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> 
            Create new Shortern Url
        </div>
    </header>
    <div >
        <br>
        
        <form style="display: inline-block;width:63%;" method="POST" action="{{ route('urlShortener') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="url" :value="__('URL(Uniform Resource Locator)')" />

                <x-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="expirationTime" :value="__('Expiration Time')" />
                <input type="datetime-local" id="expirationTime"
                    name="expiration_time" value="<?php echo date('Y-m-d h:m');?>"
                    min="<?php echo date('Y-m-d h:m');?>" max="2100-06-14T00:00">
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4 btn-info">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>      
    </div>
    <script type="text/javascript">
         $(function () {
             $('#datetimepicker1').datetimepicker();
         });
      </script>
</main>
