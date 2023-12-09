<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;
use App\Exceptions\NoDataFoundException;
use App\Exceptions\ShortlinkExistsException;

/**
 * Class URLModel
 * 
 * This class represents the URL model in the application.
 * It extends the CodeIgniter Model class and provides methods for CRUD operations on shortlinks.
 */
class URLModel extends Model
{
    /**
     * The name of the database table.
     *
     * @var string
     */
    protected $table = "shortlinks";

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = "ID";

    /**
     * The fields that are allowed to be mass assigned.
     *
     * @var array
     */
    protected $allowedFields = ["longUrl", "slug"];

    /**
     * The validation rules for the model fields.
     *
     * @var array
     */
    protected $validationRules = [
        "longUrl" => "required|valid_url_strict",
        "slug" => "required|is_unique[shortlinks.slug]",
    ];

    /**
     * Handles the find function result.
     *
     * @param mixed $resource The result of the find function.
     * @return mixed The resource if not empty, otherwise throws a NoDataFoundException.
     * @throws NoDataFoundException
     */
    private function handleFindFunction($resource)
    {
        if (empty($resource)) {
            throw new NoDataFoundException();
        } else {
            return $resource;
        }
    }

    /**
     * Checks if a shortlink with the given slug exists.
     *
     * @param string $slug The slug of the shortlink.
     * @return bool Returns true if the shortlink exists, false otherwise.
     */
    private function checkIfShortlinkExists($slug)
    {
        $shortlinkExists = $this->where("slug", $slug)->findAll();
        return !empty($shortlinkExists);
    }

    /**
     * Retrieves all shortlinks from the database.
     *
     * @return mixed All shortlinks if found, otherwise throws a NoDataFoundException.
     * @throws NoDataFoundException
     */
    public function getAllShortlinks()
    {
        $allShortlinks = $this->findAll();
        return $this->handleFindFunction($allShortlinks);
    }

    /**
     * Retrieves a shortlink with the given slug from the database.
     *
     * @param string $slug The slug of the shortlink.
     * @return mixed The shortlink if found, otherwise throws a NoDataFoundException.
     * @throws NoDataFoundException
     */
    public function getShortlink($slug)
    {
        $shortlink = $this->where("slug", $slug)->findAll();
        return $this->handleFindFunction($shortlink);
    }

    /**
     * Creates a new shortlink in the database.
     *
     * @param array $shortlink The shortlink data to be inserted.
     * @return bool Returns true if the shortlink is successfully created, otherwise throws an exception.
     * @throws Exception
     * @throws ShortlinkExistsException
     */
    public function createShortlink($shortlink)
    {
        $shortlinkExists = $this->checkIfShortlinkExists($shortlink["slug"]);
        if (!$shortlinkExists) {
            $inserted = $this->insert($shortlink);
            if ($inserted) {
                return true;
            } else {
                throw new Exception("Failed to insert shortlink");
            }
        } else {
            throw new ShortlinkExistsException();
        }
    }

    /**
     * Updates an existing shortlink in the database.
     *
     * @param array $shortlink The shortlink data to be updated.
     * @return bool Returns true if the shortlink is successfully updated, otherwise throws an exception.
     * @throws Exception
     * @throws NoDataFoundException
     * @throws ShortlinkExistsException
     */
    public function updateShortlink($shortlink)
    {
        $oldShortlinkExists = $this->checkIfShortlinkExists($shortlink["oldSlug"]);
        $newShortlinkExists = $this->checkIfShortlinkExists($shortlink["newSlug"]);

        if (!$oldShortlinkExists) {
            throw new NoDataFoundException();
        }

        if ($shortlink["oldSlug"] === $shortlink["newSlug"]) {
            $updated = $this->where("slug", $shortlink["oldSlug"])
                ->set([
                    "longUrl" => $shortlink["newLongUrl"],
                ])
                ->update();
        } elseif ($newShortlinkExists) {
            throw new ShortlinkExistsException();
        } else {
            $updated = $this->where("slug", $shortlink["oldSlug"])
                ->set([
                    "longUrl" => $shortlink["newLongUrl"],
                    "slug" => $shortlink["newSlug"],
                ])
                ->update();
        }

        if (!$updated) {
            throw new Exception("Failed to update shortlink");
        }

        return true;
    }

    /**
     * Deletes a shortlink with the given slug from the database.
     *
     * @param string $slug The slug of the shortlink to be deleted.
     * @return bool Returns true if the shortlink is successfully deleted, otherwise throws an exception.
     * @throws Exception
     * @throws NoDataFoundException
     */
    public function deleteShortlink($slug)
    {
        $shortlinkExists = $this->checkIfShortlinkExists($slug);

        if ($shortlinkExists) {
            $deleted = $this->where("slug", $slug)->delete();

            if (!$deleted) {
                throw new Exception("Failed to delete shortlink");
            } else {
                return true;
            }
        } else {
            throw new NoDataFoundException();
        }
    }
}
