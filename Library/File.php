<?php
/*
Copyright © 2016, 2018 eMedia Intellect.

This file is part of eMI FileUpload Library.

eMI FileUpload Library is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

eMI FileUpload Library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with eMI FileUpload Library. If not, see <http://www.gnu.org/licenses/>.
*/

namespace Emi\FileUpload;

class File
{
	private $error = null;
	private $mediaType = null;
	private $name = null;
	private $size = null;
	private $temporaryName = null;

	private $destinationName = null;

	public function __construct(string $name, string $mediaType, int $size, string $temporaryName)
	{
		$this->name = $name;
		$this->mediaType = $mediaType;
		$this->size = $size;
		$this->temporaryName = $temporaryName;
	}

	public function GetDestinationName() : string
	{
		if ($this->destinationName === null)
		{
			return $this->temporaryName;
		}
		else
		{
			return $this->destinationName;
		}
	}

	public function GetMediaType() : string
	{
		return $this->mediaType;
	}

	public function GetName() : string
	{
		return $this->name;
	}

	public function GetSize() : int
	{
		return $this->size;
	}

	public function GetTemporaryName() : string
	{
		return $this->temporaryName;
	}

	public function Move(string $destination) : bool
	{
		if (move_uploaded_file($this->temporaryName, $destination . '/' . basename($this->GetDestinationName())))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function SetDestinationName(string $destinationName) : void
	{
		$this->destinationName = $destinationName;
	}
}
?>