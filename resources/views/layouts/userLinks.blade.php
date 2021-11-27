<link rel="stylesheet" href="{{ asset('css/urls.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-yourLink-tab" data-bs-toggle="tab" data-bs-target="#nav-yourLink" type="button" role="tab" aria-controls="nav-yourLink" aria-selected="true">Your Links</button>
                            <button class="nav-link" id="nav-newLink-tab" data-bs-toggle="tab" data-bs-target="#nav-newLink" type="button" role="tab" aria-controls="nav-newLink" aria-selected="false">Create New Link</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                        </div>
                    </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-yourLink" role="tabpanel" aria-labelledby="nav-yourLink-tab">
                    <div class="flex">
                        <table class="urls">
                            <tr>
                                <th>Original Url</th>
                                <th>Unique Shortern Url </th>
                                <th>Access Type</th>
                                <th>Expiration Time</th>
                            </tr>
                            @foreach($urls as $url)
                            <tr>
                                <td>{{$url->original_url}}</td>
                                <td>{{$url->unique_shortern_url }}</td>
                                <td>{{$url->url_type }}</td>
                                @if($url->expiration_time > now())
                                    <td>{{$url->expiration_time}}</td>
                                @else
                                    <td class='expire'>Link Expired</td>
                                @endif
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    </div>
                    <div class="tab-pane fade" id="nav-newLink" role="tabpanel" aria-labelledby="nav-newLink-tab">
                    <header class="bg-white shadow" style="text-align:center;">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> 
                            <strong>Create New Shortern Url</strong>
                        </div>
                    </header>
                    <div>
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
                                <x-button class="ml-4 btn-info">
                                    {{ __('Submit') }}
                                </x-button>
                            </div>
                        </form>      
                    </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="card" style="width: auto">
                            <div class="card-body">
                                <h5 class="card-title">{{$user->name}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{$user->email}}</h6>
                                <p class="card-text">User Details for future.</p>
                            </div>
                        </div>
                    </div>
                    </div>

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
                        alert('This Shortern link has been expired.'); 
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
