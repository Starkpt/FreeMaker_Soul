<?php

?>

<style>
  #drop-zone-wrapper {
    cursor: pointer;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    overflow-y: auto;
    transition: background-color 0.3s, border-color 0.3s;
  }

  #drop-zone {
    cursor: pointer;
    background-color: #f9f9f9;
    max-height: 250px;
    overflow-y: auto;
    transition: background-color 0.3s, border-color 0.3s;
  }

  #drop-zone.bg-light {
    background-color: #f8f9fa !important;
    border-color: #28a745;
  }

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
    /* margin: 0; */
    font-size: 1rem;
    color: #888;
    color: #b3b3b3;
    text-align: center;
  }

  .default-btn {
    width: 32px;
    height: 32px;
    background: url("../../assets/imgs/icons/star-24x24.svg") no-repeat center center;
    background-size: 16px;
    border: none;
    cursor: pointer;
    transition: background-image 0.3s ease;
  }

  .default-btn:hover {
    background-image: url("../../assets/imgs/icons/star-fill-24x24.svg");
  }

  .default-btn.selected {
    background-image: url("../../assets/imgs/icons/star-fill-24x24.svg");
  }
</style>


<div class="mb-3">
  <!-- File upload label -->
  <label for="fileInput" class="form-label">Imagens do produto</label>

  <!-- Wrapper for drop zone and uploaded files -->
  <div id="drop-zone-wrapper" class="rounded-2">

    <div class="p-3 pt-4 pb-0 text-center">
      <p class="mt-3">Drop images here or <strong>browse files</strong></p>
      <img class="mb-3" src="../../assets/imgs/icons/upload-24x24.svg" alt="">
      <!-- Placeholder message -->
    </div>
    <p id="placeholder-message" class="text-center">No files uploaded yet.</p>

    <!-- tabIndex: Makes the drop zone focusable -->
    <!-- role: Semantic role for better accessibility -->
    <div
      id="drop-zone"
      class="p-3 pt-2"
      tabindex="0"
      role="region"
      aria-label="Drag and drop files or click to upload"
      aria-describedby="upload-hint">

      <!-- Hidden file input element -->
      <input id="fileInput" type="file" class="d-none" aria-hidden="true" multiple />

      <!-- Container for uploaded file cards -->
      <div id="files-gallery" class="d-flex flex-column gap-2 space-between"></div>
    </div>
  </div>

  <!-- Hint for default image selection -->
  <small class="text-tertiary">The first image will be the default image to be shown</small>
</div>

<script>
  // Select DOM elements for interaction
  const dropZone = document.querySelector("#drop-zone-wrapper");
  const dropContainer = document.querySelector("#drop-zone");
  const fileInput = document.querySelector("#fileInput");
  const filesGallery = document.querySelector("#files-gallery");
  const placeholder = document.querySelector("#placeholder-message");

  // Helper function to create an HTML element with attributes and text
  const createElement = (tag, attributes = {}, innerText = "") => {
    const element = document.createElement(tag);
    Object.keys(attributes).forEach((key) => {
      element[key] = attributes[key];
    });
    if (innerText) element.textContent = innerText;
    return element;
  };

  // Format file size for better readability (e.g., KB, MB, etc.)
  const formatFileSize = (size) => {
    const units = ["B", "KB", "MB", "GB"];
    let index = 0;
    while (size >= 1024 && index < units.length - 1) {
      size /= 1024;
      index++;
    }
    return `${size.toFixed(1)} ${units[index]}`;
  };

  // Handle files uploaded via drag-and-drop or input field
  const handleFiles = (files) => {
    files.forEach((file) => {
      // Only allow image files
      if (!file.type.startsWith("image/")) {
        alert(`"${file.name}" is not an image file.`);
        return;
      }

      // Read file content to display preview
      const reader = new FileReader();
      reader.onload = () => {
        const card = createCard(file, reader.result);
        filesGallery.appendChild(card);
        togglePlaceholder();
      };
      reader.readAsDataURL(file);
    });
  };

  // Create a card element for each uploaded file
  const createCard = (file, imgSrc) => {
    const card = createElement("div", {
      className: "card d-flex flex-row p-2 pe-4 gap-2 rounded-2 align-items-center",
    });

    const img = createElement("img", {
      src: imgSrc,
      alt: file.name, // Accessibility improvement
    });

    // File details (name and size)
    const fileDetails = createFileDetails(file);

    // Default image button
    const setDefaultButton = createDefaultButton();

    // Delete button
    const deleteButton = createDeleteButton(file, card);

    card.appendChild(img);
    card.appendChild(fileDetails);
    card.appendChild(setDefaultButton);
    card.appendChild(deleteButton);

    return card;
  };

  // Generate file details section
  const createFileDetails = (file) => {
    const fileDetails = createElement("div", {
      className: "file-details gap-1"
    });
    const fileName = createElement("p", {
      className: "fw-bold"
    }, file.name);
    const fileMeta = createElement("div", {
      className: "file-meta d-flex gap-1"
    });
    const fileSize = createElement("p", {}, formatFileSize(file.size));
    const fileType = createElement("p", {
      className: "fst-italic"
    }, file.type);

    fileMeta.appendChild(fileSize);
    fileMeta.appendChild(fileType);
    fileDetails.appendChild(fileName);
    fileDetails.appendChild(fileMeta);

    return fileDetails;
  };

  // Generate the default button for selecting the main image
  const createDefaultButton = () => {
    const button = createElement("button", {
      className: "btn btn-sm btn-light default-btn",
      title: "Set as default",
    });

    button.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      // Ensure only one button is selected
      document.querySelectorAll(".default-btn").forEach((btn) => btn.classList.remove("selected"));
      button.classList.toggle("selected");
    });

    return button;
  };

  // Generate delete button for removing an uploaded file
  const createDeleteButton = (file, card) => {
    const button = createElement("button", {
      className: "btn btn-outline-danger btn-sm",
      "aria-label": `Delete ${file.name}`,
    });

    const deleteImg = createElement("img", {
      src: "../../assets/imgs/icons/trash-24x24-red.svg",
      alt: `Delete ${file.name}`,
      width: 16,
      height: 16,
    });

    button.appendChild(deleteImg);

    button.addEventListener("click", (e) => {
      e.stopPropagation();
      card.remove();
      togglePlaceholder();
    });

    return button;
  };

  // Toggle visibility of the placeholder message
  const togglePlaceholder = () => {
    placeholder.style.display = filesGallery.childElementCount ? "none" : "block";
  };

  // Drag-and-drop events to enable file upload
  ["dragenter", "dragover", "dragleave", "drop"].forEach((event) =>
    dropZone.addEventListener(event, (e) => {
      e.preventDefault();
      e.stopPropagation();
    })
  );

  dropZone.addEventListener("dragenter", () => dropZone.classList.add("bg-light"));
  dropZone.addEventListener("dragleave", (e) => {
    if (!dropZone.contains(e.relatedTarget)) dropZone.classList.remove("bg-light");
  });

  dropZone.addEventListener("drop", (e) => {
    dropZone.classList.remove("bg-light");
    handleFiles([...e.dataTransfer.files]);
  });

  // Handle click and keyboard input to open the file dialog
  dropZone.addEventListener("click", () => fileInput.click());
  fileInput.addEventListener("change", (e) => handleFiles([...e.target.files]));

  dropZone.addEventListener("keydown", (e) => {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      fileInput.click();
    }
  });
</script>