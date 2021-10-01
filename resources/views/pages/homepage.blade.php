@extends('layouts.default')

@section('introduction_text')
    <p class="bold-p">{{ __('introduction_texts.homepage_line_1') }}</p>
    <p class="bold-p">{{ __('introduction_texts.homepage_line_2') }}</p>
    <p class="bold-p">{{ __('introduction_texts.homepage_line_3') }}</p>
@endsection

@section('content')

    <h1>
        @section('title')
            {{ __('misc.all_brands') }}
        @show
    </h1>

        <div class="col-md-12">

            <ul>
                @foreach($query as $brand)
                    @php
                        $manualtype = DB::table('manual_type')->where('manual_id','=',$brand->id)->get();
                        $manuallist = array($manualtype);
                        $type_id = $manuallist[0][0]->type_id;

                        $type = DB::table('types')->where('id','=',$type_id)->get();
                        $typelist = array($type);
                        $brandid = $typelist[0][0]->brand_id;

                        $test = DB::table('brands')->where('id','=',$brandid)->get();
                        $brandname = $test[0]->name;
                        $brandtype = $typelist[0][0]->name;
                    @endphp
                    <li class="nopoint-li">
                        <a class="button-styling" href="/">{{ $brandname }} : {{ $brandtype  }}</a>
                    </li>
                @endforeach
            </ul>

        </div>

    <?php
    $size = count($brands);
    $columns = 3;
    $chunk_size = ceil($size / $columns);
    ?>

    <div class="container">
        <!-- Example row of columns -->
        <div class="row">

            @foreach($brands->chunk($chunk_size) as $chunk)
                <div class="col-md-4">

                    <ul>
                        @foreach($chunk as $brand)

                            <?php
                            $current_first_letter = strtoupper(substr($brand->name, 0, 1));

                            if (!isset($header_first_letter) || (isset($header_first_letter) && $current_first_letter != $header_first_letter)) {
                                echo '</ul>
						<h2>' . $current_first_letter . '</h2>
						<ul>';
                            }
                            $header_first_letter = $current_first_letter
                            ?>

                            <li class="nopoint-li">
                                <a class="button-styling" href="/{{ $brand->id }}/{{ $brand->name_url_encoded }}/">{{ $brand->name }}</a>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <?php
                unset($header_first_letter);
                ?>
            @endforeach

        </div>

    </div>

@endsection
