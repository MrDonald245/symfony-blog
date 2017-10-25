<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     */
    private $publication_date;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="string")
     */

    private $author;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param string $format by default it is 'm-d-Y'
     * @return string
     */
    public function getPublicationDate(string $format = 'm-d-Y'): string {
        return $this->publication_date->format($format);
    }

    /**
     * @param DateTime $publication_date
     * @return $this
     */
    public function setPublicationDate(DateTime $publication_date): Post {
        $this->publication_date = $publication_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title): Post {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return $this
     */
    public function setText($text): Post {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return $this
     */
    public function setAuthor($author): Post {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string a first paragraph of the post text.
     */
    public function getFirstParagraph(): string {
        return explode("\r\n", $this->text)[0];
    }

    /**
     * Adds to the first paragraph 'lead' class
     * @return string prepared for html output.
     */
    public function getTextHTML(): string {
        $first_paragraph = $this->getFirstParagraph();
        $replacement = '<span class="lead">' . $first_paragraph . '</span>';
        $new_text = str_replace($first_paragraph, $replacement, $this->text);

        return nl2br($new_text);
    }
}

