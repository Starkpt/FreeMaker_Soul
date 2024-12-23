<?php

?>

<style>
  #drop-zone {
    transition: background-color 0.3s, border-color 0.3s;
    cursor: pointer;
    background-color: #f9f9f9;
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 16px;
    max-height: 250px;
    overflow-y: auto;
  }

  #drop-zone.bg-light {
    background-color: #f8f9fa !important;
    border-color: #28a745;
  }

  #files-gallery {}

  .card {
    border: 1px solid #ddd;
    background-color: #ffffff;
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .card>img {
    width: 80px;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
  }


  .card .btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
  }

  .card .file-details {
    max-width: 179px;
    display: flex;
    flex-grow: 1;
    flex-direction: column;
  }

  .card .file-details p {
    margin: 0;
    font-size: 0.8rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .card .file-details button {
    font-size: 0.8rem;
    color: #007bff;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
  }

  #placeholder-message {
    margin: 0;
    font-size: 1rem;
    color: #888;
    text-align: center;
  }
</style>

<!-- Upload and preview section -->
<div class="mb-3">
  <label for="fileInput" class="form-label">Imagens do produto</label>

  <div id="drop-zone-wrapper">
    <!-- Drop zone for drag-and-drop or click-to-upload -->
    <div
      id="drop-zone"
      tabindex="0"
      role="region"
      aria-label="Drag and drop files or click to upload"
      aria-describedby="upload-hint">
      <p id="placeholder-message" class="text-center">No files uploaded yet.</p>
      <input id="fileInput" type="file" class="d-none" aria-hidden="true" multiple />
      <!-- Gallery for displaying uploaded files -->
      <div id="files-gallery" class="d-flex flex-column gap-2 space-between"></div>
    </div>
  </div>
  <small class="text-tertiary">The first image will be the default image to be shown</small>
</div>

<script>
  // Get references to DOM elements
  const dropZone = document.querySelector("#drop-zone");
  const fileInput = document.querySelector("#fileInput");
  const filesGallery = document.querySelector("#files-gallery");
  const placeholder = document.querySelector("#placeholder-message");

  // Function to handle uploaded files
  const handleFiles = (files) => {
    files.forEach((file) => {
      // Skip non-image files
      if (!file.type.startsWith("image/")) {
        alert(`"${file.name}" is not an image file.`);
        return;
      }

      // Read the image file
      const reader = new FileReader();
      reader.onload = () => {
        // Create a card element for each uploaded file
        const card = document.createElement("div");
        card.className = "card d-flex flex-row p-2 pe-4 gap-2 rounded-2 align-items-center";

        // Create an image element for the uploaded file preview
        const img = document.createElement("img");
        img.src = reader.result;
        img.alt = file.name;

        // Create a delete button
        const deleteButton = document.createElement("button");
        deleteButton.className = "btn btn-outline-danger btn-sm";
        deleteButton.setAttribute("aria-label", `Delete ${file.name}`);

        // Add a trash icon to the delete button
        const deleteImg = document.createElement("img");
        deleteImg.src = "../../assets/imgs/icons/trash-24x24-red.svg";
        deleteImg.alt = `Delete ${file.name}`;
        deleteImg.width = 16;
        deleteImg.height = 16;

        // Change trash icon on hover
        deleteButton.appendChild(deleteImg);
        deleteButton.addEventListener("mouseenter", () => {
          deleteImg.src = "../../assets/imgs/icons/trash-24x24-white.svg";
        });
        deleteButton.addEventListener("mouseleave", () => {
          deleteImg.src = "../../assets/imgs/icons/trash-24x24-red.svg";
        });
        deleteButton.addEventListener("click", (e) => {
          e.stopPropagation(); // Prevent event bubbling
          card.remove();
          togglePlaceholder();
        });

        // File details section
        const fileDetails = document.createElement("div");
        fileDetails.className = "file-details gap-1";

        // File name
        const fileName = document.createElement("p");
        fileName.className = "fw-bold";
        fileName.textContent = file.name;

        // File size and type
        const fileMeta = document.createElement("div");
        fileMeta.className = "file-meta d-flex gap-1";

        const fileSize = document.createElement("p");
        fileSize.textContent = file.size;

        const fileType = document.createElement("p");
        fileType.className = "fst-italic";
        fileType.textContent = file.type;

        // "Set as default" button
        const setDefaultButton = document.createElement("button");
        setDefaultButton.className = "btn btn-sm btn-light";

        // Add a star icon to the button
        const defaultImg = document.createElement("img");
        defaultImg.src = "../../assets/imgs/icons/star-24x24.svg";
        defaultImg.alt = file.name;
        defaultImg.width = 16;
        defaultImg.height = 16;

        setDefaultButton.appendChild(defaultImg);

        // Event for setting the default image
        setDefaultButton.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          alert(`Set "${file.name}" as the default photo.`);
        });

        // Build the card structure
        fileMeta.appendChild(fileSize);
        fileMeta.appendChild(fileType);

        fileDetails.appendChild(fileName);
        fileDetails.appendChild(fileMeta);

        card.appendChild(img);
        card.appendChild(fileDetails);
        card.appendChild(setDefaultButton);
        card.appendChild(deleteButton);

        filesGallery.appendChild(card);

        // Prevent clicks on the card from propagating
        card.addEventListener("click", (e) => e.stopPropagation());
        togglePlaceholder();
      };
      reader.readAsDataURL(file);
    });
  };

  // Toggle placeholder visibility
  const togglePlaceholder = () => {
    placeholder.style.display = filesGallery.childElementCount ? "none" : "block";
  };

  // Prevent default behaviors for drag-and-drop events
  ["dragenter", "dragover", "dragleave", "drop"].forEach((event) =>
    dropZone.addEventListener(event, (e) => {
      e.preventDefault();
      e.stopPropagation();
    })
  );

  // Highlight drop zone on drag events
  dropZone.addEventListener("dragenter", () => dropZone.classList.add("bg-light"));
  dropZone.addEventListener("dragleave", () => dropZone.classList.remove("bg-light"));
  dropZone.addEventListener("drop", (e) => {
    dropZone.classList.remove("bg-light");
    handleFiles([...e.dataTransfer.files]);
  });

  // Click to trigger file input
  dropZone.addEventListener("click", () => fileInput.click());
  fileInput.addEventListener("change", (e) => handleFiles([...e.target.files]));

  // Accessibility: Open file input on "Enter" or "Space" keypress
  dropZone.addEventListener("keydown", (e) => {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      fileInput.click();
    }
  });
</script>