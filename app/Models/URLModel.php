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
    protected $table = "shortlinks";
    protected $primaryKey = "ID";
    protected $allowedFields = ["longUrl", "slug"];
    protected $validationRules = [
        "longUrl" => "required|valid_url_strict",
        "slug" => "required|is_unique[shortlinks.slug]",
    ];

    /**
     * Handle the find function result.
     * 
     * @param mixed $resource The result of the find function.
     * @return mixed The resource if not empty, otherwise throws a NoDataFoundException.
     * @throws NoDataFoundException If the resource is empty.
     */
    private function _handleFindFunction($resource)
    {
        if (empty($resource)) {
            throw new NoDataFoundException();
        } else {
            return $resource;
        }
    }

    /**
     * Check if a shortlink with the given slug exists.
     * 
     * @param string $slug The slug of the shortlink.
     * @return bool True if the shortlink exists, false otherwise.
     */
    private function _checkIfShortlinkExists($slug)
    {
        $shortlinkExists = $this->where("slug", $slug)->findAll();
        if (!empty($shortlinkExists)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all shortlinks.
     * 
     * @return mixed All shortlinks if found, otherwise throws a NoDataFoundException.
     * @throws NoDataFoundException If no shortlinks are found.
     */
    public function getAllShortlinks()
    {
        $allShortlinks = $this->findAll();
        return $this->_handleFindFunction($allShortlinks);
    }

    /**
     * Get a shortlink by slug.
     * 
     * @param string $slug The slug of the shortlink.
     * @return mixed The shortlink if found, otherwise throws a NoDataFoundException.
     * @throws NoDataFoundException If the shortlink is not found.
     */
    public function getShortlink($slug)
    {
        $shortlink = $this->where("slug", $slug)->findAll();
        return $this->_handleFindFunction($shortlink);
    }

    /**
     * Create a new shortlink.
     * 
     * @param array $shortlink The shortlink data.
     * @return bool True if the shortlink is created successfully, otherwise throws an exception.
     * @throws Exception If failed to insert the shortlink.
     * @throws ShortlinkExistsException If the shortlink slug already exists.
     */
    public function createShortlink($shortlink)
    {
        $shortlinkExists = $this->_checkIfShortlinkExists($shortlink["slug"]);
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
     * Update an existing shortlink.
     * 
     * @param array $shortlink The updated shortlink data.
     * @return bool True if the shortlink is updated successfully, otherwise throws an exception.
     * @throws Exception If failed to update the shortlink.
     * @throws NoDataFoundException If the old shortlink slug is not found.
     * @throws ShortlinkExistsException If the new shortlink slug already exists.
     */
    public function updateShortlink($shortlink)
    {
        $oldShortlinkExists = $this->_checkIfShortlinkExists(
            $shortlink["oldSlug"]
        );
        $newShortlinkExists = $this->_checkIfShortlinkExists(
            $shortlink["newSlug"]
        );

        if ($oldShortlinkExists) {
            if ($shortlink["oldSlug"] === $shortlink["newSlug"]) {
                $updated = $this->where("slug", $shortlink["oldSlug"])
                    ->set([
                        "longUrl" => $shortlink["newLongUrl"],
                    ])
                    ->update();
            } elseif (!$newShortlinkExists) {
                $updated = $this->where("slug", $shortlink["oldSlug"])
                    ->set([
                        "longUrl" => $shortlink["newLongUrl"],
                        "slug" => $shortlink["newSlug"],
                    ])
                    ->update();
            } else {
                throw new ShortlinkExistsException();
            }

            if (!$updated) {
                throw new Exception("Failed to update shortlink");
            } else {
                return true;
            }
        } else {
            throw new NoDataFoundException();
        }
    }

    /**
     * Delete a shortlink by slug.
     * 
     * @param string $slug The slug of the shortlink to delete.
     * @return bool True if the shortlink is deleted successfully, otherwise throws an exception.
     * @throws Exception If failed to delete the shortlink.
     * @throws NoDataFoundException If the shortlink is not found.
     */
    public function deleteShortlink($slug)
    {
        $shortlinkExists = $this->_checkIfShortlinkExists($slug);

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
