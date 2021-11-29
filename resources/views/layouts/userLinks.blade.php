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
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-yourLink-tab" data-bs-toggle="tab" data-bs-target="#nav-yourLink" type="button" role="tab" aria-controls="nav-yourLink" aria-selected="true">Your Links</button>
                            <button class="nav-link" id="nav-newLink-tab" data-bs-toggle="tab" data-bs-target="#nav-newLink" type="button" role="tab" aria-controls="nav-newLink" aria-selected="false">Create New Link</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">User</button>
                        </div>
                    </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-yourLink" role="tabpanel" aria-labelledby="nav-yourLink-tab">
                    <div class="flex">
                        <table class="urls">
                            <tr>
                                <th>Original Url</th>
                                <th>Access Shortern Link</th>
                                <th>Access Type</th>
                                <th>Expiration Time</th>
                                <th>Action</th>
                            </tr>
                            @foreach($urls as $url)
                            <tr>
                                <td style="column-width: 100px;overflow: hidden !important;">{{$url->original_url}}</td>
                                <td><input type="text" value="{{$url->unique_shortern_url }}" readonly></td>
                                <td>{{$url->url_type }}</td>
                                @if($url->expiration_time > now())
                                    <td>{{$url->expiration_time}}</td>
                                @else
                                    <td class='expire'>Link Expired</td>
                                @endif
                                <td><a class="btn btn-info" onclick="updateLink({{$url}})" type="button" data-bs-toggle="modal" href="#UpdateLinkModal">update</a> &nbsp;&nbsp; <a class="btn btn-danger" type="button" onclick="deleteUrl('{{$url->id}}')" data-bs-toggle="modal" href="#deleteLinkModal">delete</a></td>
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

                            <div class="">
                            <br>
                            <p>Select your link type:</p>
                            <div>
                                <input type="radio" id="Private" name="linkType" value="Private">
                                <label for="Private">Private</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="Public" name="linkType" value="Public">
                                <label for="Public">Public</label>
                            </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4 btn-info" style="background-color:#4267B2;">
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

<div class="modal fade" id="UpdateLinkModal" aria-hidden="true" aria-labelledby="UpdateLinkModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UpdateLinkModalLabel">Update Link Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="userData" style=""></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="updateInfo" onclick="updateinfo();">Update Info</button>
                </div>
           </div>
        </div>
    </div>

    <div class="modal fade" id="deleteLinkModal" aria-hidden="true" aria-labelledby="deleteLinkModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLinkModalLabel">Delete The Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <h4>Are you sure deleting this link information?</h4>
                </div>
                <div class="modal-footer">
                    <div class="deleteBtn"></div>
                </div>
           </div>
        </div>
    </div>

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
                        alert('This Link can not access.'); 
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

<script>
    $(document).ready(function() {
        const basePath = window.location.origin;
    });

    function updateLink(url){
        $(".LinkInfo").remove();
        let linkInfo = $(".userData");
        linkInfo.append(`
            <div class="LinkInfo">
                <div class="">
                    <input type="hidden" class="form-control" id="getUrlId" value="${url.id}"/>
                    <label for="updateOriginalLink" class="form-label">Original Link</label>
                    <input type="text" class="form-control" id="updateOriginalLink" value="${url.original_url}"/>
                </div>
                <div class="mt-4">
                    <input type="hidden" id="expTime" value="${url.expiration_time}">
                    <label for="updateExpirationTime" class="form-label">Expiration Time</label>
                    <input type="datetime-local" id="updateExpirationTime"
                        name="expiration_time" value="${url.expiration_time}"
                        min="<?php echo date('Y-m-d h:m');?>" max="2100-06-14T00:00"/>
                </div>

                <div class="">
                    <br>
                    <p>Select your link type:</p>
                    <div>
                        <input type="hidden" id="lType" value="${url.url_type}">
                        <input type="radio" class="linkType" name="linkType" value="Private">
                        <label for="updatePrivate">Private</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" class="linkType" name="linkType" value="Public">
                        <label for="updatePublic">Public</label>
                        
                    </div>
                </div>
            </div>     
        `);
    }
    function updateinfo(){
        let urlId = $("#getUrlId").val();
        let originalUrl = $("#updateOriginalLink").val();
        let expiraationTime = $("#updateExpirationTime").val();
        let linkType = $('input[name="linkType"]:checked').val();
        console.log("l:"+linkType);

        if(expiraationTime == ''){
            expiraationTime = $("#expTime").val();
        }

        if(linkType == undefined){
            linkType = $("#lType").val();
        }

        $.ajax({
            url :  basePath + '/update/url/' + urlId,
            type : 'PUT',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            data : {
                'urlId' : urlId,
                'originalUrl' : originalUrl,
                'expiraationTime' : expiraationTime,
                'linkType' : linkType
            },
            dataType:'json',
            success : function(data) { 
                if(data == true){
                    window.location.reload();
                }
                else{
                    alert('Can not update the link information.');
                }
            },
            error : function(request,error)
            {
                alert('Url update request can not proceed');
            }
        });
    }

    function deleteUrl(urlId){
        $("#deleteInfo").remove();
        let deleteBtn = $(".deleteBtn");
        deleteBtn.append(`
            <button class="btn btn-success" id="deleteInfo" onclick="deleteInfo(${urlId});">Delete Info</button>
        `);
    }

    function deleteInfo(urlId){
        $.ajax({
            url :  basePath + '/delete/url/' + urlId,
            type : 'DELETE',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            data : {
                'urlId' : urlId
            },
            dataType:'json',
            success : function(data) { 
                if(data == true){
                   window.location.reload();
                }
                else{
                    alert('Could not delete the url information.');
                }
            },
            error : function(request,error)
            {
                alert('Url delete request can not proceed');
            }
        });
    }
</script>
