<?php
/**
 * Description of Meta.php
 *
 * @author Vladimir Gromyak
 */
namespace UWC\ID3;


class Meta {

    const FIELD_TITLE   = 'title';
    const FIELD_ARTIST  = 'artist';
    const FIELD_ALBUM   = 'album';
    const FIELD_YEAR    = 'year';
    const FIELD_GENRE   = 'genre';
    const FIELD_COMMENT = 'comment';
    const FIELD_TRACK   = 'track';

    /**
     * string with maximum of 30 characters 	v1.0, v1.1
     *
     * @var string
     */
    private $title;

    /**
     * string with maximum of 30 characters 	v1.0, v1.1
     *
     * @var string
     */
    private $artist;

    /**
     * string with maximum of 30 characters 	v1.0, v1.1
     *
     * @var string
     */
    private $album;

    /**
     * 4 digits 	v1.0, v1.1
     *
     * @var int
     */
    private $year;

    /**
     * integer value between 0 and 147 	v1.0, v1.1
     *
     * @var int
     */
    private $genre;

    /**
     * string with maximum of 30 characters (28 in v1.1) 	v1.0, v1.1
     *
     * @var string
     */
    private $comment;

    /**
     * integer between 0 and 255 	v1.1
     *
     * @var int
     */
    private $track;

    /**
     * @var array
     */
    private $additional;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return string
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param string $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param int $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return int
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param int $track
     */
    public function setTrack($track)
    {
        $this->track = $track;
    }

    /**
     * @return array
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * @param array $additional
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;
    }

    public static function fromArray($data)
    {
        $meta = new self();
        if (isset($data[self::FIELD_TITLE])) {
            $meta->setTitle($data[self::FIELD_TITLE]);
            unset($data[self::FIELD_TITLE]);
        }
        if (isset($data[self::FIELD_ARTIST])) {
            $meta->setArtist($data[self::FIELD_ARTIST]);
            unset($data[self::FIELD_ARTIST]);
        }
        if (isset($data[self::FIELD_ALBUM])) {
            $meta->setAlbum($data[self::FIELD_ALBUM]);
            unset($data[self::FIELD_ALBUM]);
        }
        if (isset($data[self::FIELD_YEAR])) {
            $meta->setYear($data[self::FIELD_YEAR]);
            unset($data[self::FIELD_YEAR]);
        }
        if (isset($data[self::FIELD_GENRE])) {
            $meta->setGenre($data[self::FIELD_GENRE]);
            unset($data[self::FIELD_GENRE]);
        }
        if (isset($data[self::FIELD_COMMENT])) {
            $meta->setComment($data[self::FIELD_COMMENT]);
            unset($data[self::FIELD_COMMENT]);
        }
        if (isset($data[self::FIELD_TRACK])) {
            $meta->setTrack($data[self::FIELD_TRACK]);
            unset($data[self::FIELD_TRACK]);
        }
        if (!empty($data)) {
            $meta->setAdditional($data);
        }
        return $meta;
    }

    public function toArray()
    {
        $data = [];
        if (!empty($this->getTitle())) {
            $data[Meta::FIELD_TITLE] = $this->getTitle();
        }
        if (!empty($this->getArtist())) {
            $data[Meta::FIELD_ARTIST] = $this->getArtist();
        }
        if (!empty($this->getAlbum())) {
            $data[Meta::FIELD_ALBUM] = $this->getAlbum();
        }
        if (!empty($this->getYear())) {
            $data[Meta::FIELD_YEAR] = $this->getYear();
        }
        if (!empty($this->getGenre())) {
            $data[Meta::FIELD_GENRE] = $this->getGenre();
        }
        if (!empty($this->getComment())) {
            $data[Meta::FIELD_COMMENT] = $this->getComment();
        }
        if (!empty($this->getTrack())) {
            $data[Meta::FIELD_TRACK] = $this->getTrack();
        }
        if (!empty($this->getAdditional())) {
            $data = array_merge($data, $this->getAdditional());
        }
        return $data;
    }

}