@extends('layouts.app')
@php
    use App\Comment;
    $comment = new Comment;
    $comments = Comment::all();
    use App\Post;
    $post = new Post;
    $posts = Post::all();
@endphp
@section('style')
    <style>
        .col-12{
            margin:10px 0;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        @auth
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('post.store') }}" method="POST">
                        @csrf
                        <div class="card-header">Criar nova postagem</div>
                        <div class="card-body">
                            <label for="conteudo">Postagem</label>
                            <textarea name="conteudo" id="conteudo" rows="10" cols="80" ></textarea>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse">
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endauth
        <div class="col-md-9 col-12">
            @foreach ($posts as $p)
            <div class="card">
                <div class="card-header">Título da postagem</div>
                <div class="card-body">


                <h5>Autor: <small>{{ $p['author'] }}</small></h5>
                    <p>
                        {{ strip_tags($p['content']) }}
                    </p>
                    <hr>
                <a href="#comentarios-{{ $p['id'] }}" data-toggle="collapse" aria-expanded="false" aria-controls="comentarios-1">
                        <small>
                            comentários
                        </small>
                    </a>
                <div class="my-2 comentarios collapse" id="comentarios-{{ $p['id'] }}">
                        @php
                            $comments = Comment::where('post_id','=',$p['id'])->get();
                        @endphp
                        @foreach ($comments as $c)
                        @comentario(["autor"=>$c['author']])
                            <p>{{ $c['content'] }}</p>
                        @endcomentario
                        @endforeach
                    </div>
                    @auth
                        <hr>
                        <div>
                            <form action="{{ route('comentario.store',$p['id']) }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value={{ $p['id'] }}>
                                <div class="form-group">
                                    <label for="comentario">Comentario</label>
                                    <textarea name="comentario" id="comentario" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Salvar comentário</button>
                            </form>
                        </div>
                    @endauth

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        window.onload = function(){
            CKEDITOR.replace('conteudo')
            CKEDITOR.config.height = 100;
        }
    </script>
@endsection
