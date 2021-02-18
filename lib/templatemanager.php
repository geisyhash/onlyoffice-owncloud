<?php
/**
 *
 * (c) Copyright Ascensio System SIA 2020
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace OCA\Onlyoffice;

use OCP\Files\Folder;

/**
 * Template manager
 *
 * @package OCA\Onlyoffice
 */
class TemplateManager {

    /**
     * Get global template directory
     *
     * @return Folder
     */
    public static function GetGlobalTemplateDir() {
        $rootFolder = \OC::$server->getRootFolder();

        $appDir = $rootFolder->nodeExists("onlyoffice") ? $rootFolder->get("onlyoffice") : $rootFolder->newFolder("onlyoffice");
        $templateDir = $appDir->nodeExists("template") ? $appDir->get("template") : $appDir->newFolder("template");

        return $templateDir;
    }

    /**
     * Get global templates
     *
     * @return array
     */
    public static function GetGlobalTemplates() {
        $templates = [];
        $templateDir = self::GetGlobalTemplateDir();

        $templatesList = $templateDir->getDirectoryListing();
        foreach ($templatesList as $templateItem) {
            $template = [
                "id" => $templateItem->getId(),
                "name" => $templateItem->getName(),
                "type" => self::GetTypeTemplate($templateItem->getMimeType())
            ];
            array_push($templates, $template);
        }

        return $templates;
    }

    /**
     * Get type template from mimetype
     * 
     * @param string $mime - mimetype 
     *
     * @return string
     */
    public static function GetTypeTemplate($mime) {
        switch($mime) {
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                return "document";
            case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                return "spreadsheet";
            case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
                return "presentation";
        }

        return "";
    }
}