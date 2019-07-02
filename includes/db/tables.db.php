<?php

class Table {

    /**
     * Table: users
     * columns: 8
     */
    public static $users = array (
        "table" => "users",
        "columns" => array (
            "_id" => "_id",
            "uname" => "username",
            "fname" => "firstname",
            "lname" => "lastname",
            "email" => "email",
            "paswd" => "password",
            "prpic" => "profile_pic",
            "crtat" => "created_at",
        ),
    );

    /**
     * Table: songs
     * columns: 9
     */
    public static $songs = array (
        "table" => "songs",
        "columns" => array (
            "_id" => "_id",
            "title" => "title",
            "artist" => "artist",
            "album" => "album",
            "genre" => "genre",
            "duration" => "duration",
            "path" => "path",
            "album_order" => "album_order",
            "plays" => "plays",
        ),
    );

    /**
     * Table: genres
     * columns: 2
     */
    public static $genres = array (
        "table" => "genres",
        "columns" => array (
            "_id" => "_id",
            "name" => "name",
        ),
    );

    /**
     * Table: artists
     * columns: 2
     */
    public static $artists = array (
        "table" => "artists",
        "columns" => array (
            "_id" => "_id",
            "name" => "name",
        ),
    );

    /**
     * Table: albums
     * columns: 5
     */
    public static $albums = array (
        "table" => "albums",
        "columns" => array (
            "_id" => "_id",
            "title" => "title",
            "artist" => "artist",
            "genre" => "genre",
            "artwork_path" => "artwork_path",
        ),
    );

    /**
     * Table: playlists
     * columns: 4
     */
    public static $playlists = array (
        "table" => "playlists",
        "columns" => array (
            "_id" => "_id",
            "name" => "name",
            "owner" => "owner",
            "date_created" => "date_created"
        ),
    );

    /**
     * Table: playlist_songs
     * columns: 4
     */
    public static $playlist_songs = array (
        "table" => "playlist_songs",
        "columns" => array (
            "_id" => "_id",
            "song_id" => "song_id",
            "playlist_id" => "playlist_id",
            "playlist_order" => "playlist_order"
        ),
    );

}

?>