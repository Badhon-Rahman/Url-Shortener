<link rel="stylesheet" href="{{ asset('css/urls.css') }}">
<x-app-layout>
    <x-slot name="header">
        <div>
            <x-label for="url" :value="__('Pest Shortern Link Here')" />
            <x-input id="accessUrl" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required autofocus />
            <div class="flex items-center justify-end mt-4">
                <button class="CButton">
                    {{ __('Access Link') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="urls">
                        <tr>
                            <th>Unique Shortern Url </th>
                            <th>Expiration Time</th>
                        </tr>
                        @foreach($urls as $url)
                            @if($url->expiration_time > now() && $url->url_type == 'Public')
                                <tr>
                                    <td>{{$url->unique_shortern_url }}</td>
                                    <td>{{$url->expiration_time}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    const basePath = window.location.origin;

    $(".CButton").click(function(){
        let accessLink = $("#accessUrl").val();
        
        if(accessLink != ''){
            alert(basePath+ " "+ accessLink);
            $.ajax({
                url :  basePath + '/access-link',
                type : 'GET',
                data : {
                    'shorternUrl' : accessLink
                },
                dataType:'json',
                success : function(data) {  
                    if(data != ''){
                        window.open( data[0].original_url, '_blank');
                    }
                    else{
                        alert('Url does not found'); 
                    }    
                },
                error : function(request,error)
                {
                    alert('Url access request can not proceed');
                }
            });
        }
        else{
            alert("Please enter the shortern url To access that link.");
        }
    });
</script>
