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
                    <th>Original Url</th>
                    <th>Unique Shortern Url </th>
                    <th>Access Type</th>
                    <th>Expiration Time</th>
                </tr>
                @foreach($urls as $url)
                <tr>
                    <td>{{$url->original_url}}</td>
                    <td>{{$url->unique_shortern_url}}</td>
                    <td>{{$url->url_type}}</td>
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
</main>
