@include('layouts.admin.admin')
<link rel="stylesheet" href="{{ asset('css/urls.css') }}">

<main style="text-align: center;">
        <!-- Page Heading -->
    <header class="bg-white shadow" style="text-align:center;">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> 
            <strong>Url Dashboard</strong>
        </div>
    </header>
    <div class="card" style="width: auto">
        <div class="card-body flex">
            <table class="urls">
                <tr>
                    <th>Created By(User Id)</th>
                    <th>Original Url</th>
                    <th>Access Shortern Link</th>
                    <th>Access Type</th>
                    <th>Expiration Time</th>
                    <th>Action</th>
                </tr>
                @foreach($urls as $url)
                <tr>
                    <td>{{$url->user_id}}</td>
                    <td style="column-width: 100px;overflow: hidden !important;">{{$url->original_url}}</td>
                    <td><input type="text" value="{{$url->unique_shortern_url }}" readonly></td>
                    <td>{{$url->url_type}}</td>
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
</main>

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
