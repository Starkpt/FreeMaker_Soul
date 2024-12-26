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


  /* Normal state: star outline icon */
  .default-btn {
    width: 32px;
    height: 32px;
    background: url("../../assets/imgs/icons/star-24x24.svg") no-repeat center center;
    background-size: 16px;
    border: none;
    cursor: pointer;
    transition: background-image 0.3s ease;
  }

  /* Hover state: filled star icon */
  .default-btn:hover {
    background-image: url("../../assets/imgs/icons/star-fill-24x24.svg");
  }

  .default-btn.selected {
    background-image: url("../../assets/imgs/icons/star-fill-24x24.svg");
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

  // Utility function to create DOM elements
  const createElement = (tag, attributes = {}, innerText = "") => {
    const element = document.createElement(tag);
    Object.keys(attributes).forEach((key) => {
      element[key] = attributes[key];
    });
    if (innerText) element.textContent = innerText;
    return element;
  };

  // Function to handle uploaded files
  const handleFiles = (files) => {
    files.forEach((file) => {
      if (!file.type.startsWith("image/")) {
        alert(`"${file.name}" is not an image file.`);
        return;
      }

      const reader = new FileReader();
      reader.onload = () => {
        // Build the card for each file
        const card = createCard(file, reader.result);
        filesGallery.appendChild(card);
        togglePlaceholder();
      };
      reader.readAsDataURL(file);
    });
  };

  // Function to create a card for a file
  const createCard = (file, imgSrc) => {
    const card = createElement("div", {
      className: "card d-flex flex-row p-2 pe-4 gap-2 rounded-2 align-items-center",
    });

    // Image preview
    const img = createElement("img", {
      src: imgSrc,
      alt: file.name
    });

    // File details
    const fileDetails = createFileDetails(file);

    // "Set as default" button
    const setDefaultButton = createDefaultButton(file);

    // Delete button
    const deleteButton = createDeleteButton(file, card);

    // Assemble card
    card.appendChild(img);
    card.appendChild(fileDetails);
    card.appendChild(setDefaultButton);
    card.appendChild(deleteButton);

    return card;
  };

  // Function to create file details section
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

    const fileSize = createElement("p", {}, `${file.size}b`);
    const fileType = createElement("p", {
      className: "fst-italic"
    }, file.type);

    fileMeta.appendChild(fileSize);
    fileMeta.appendChild(fileType);
    fileDetails.appendChild(fileName);
    fileDetails.appendChild(fileMeta);

    return fileDetails;
  };

  // Function to create the "Set as default" button
  const createDefaultButton = (file) => {
    const button = createElement("button", {
      className: "btn btn-sm btn-light default-btn",
      title: `Set ${file.name} as default`,
    });

    const defaultImg = createElement("img", {
      src: "../../assets/imgs/icons/star-24x24.svg",
      alt: `Set ${file.name} as default`,
      width: 16,
      height: 16,
    });

    button.appendChild(defaultImg);

    // Change icon on hover
    button.addEventListener("mouseenter", () => {
      defaultImg.src = "../../assets/imgs/icons/star-fill-24x24.svg";
    });
    button.addEventListener("mouseleave", () => {
      defaultImg.src = "../../assets/imgs/icons/star-24x24.svg";
    });

    // Mark file as default
    button.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      const isSelected = button.classList.contains("selected");

      // Remove 'selected' class from all default buttons
      const allDefaultButtons = document.querySelectorAll(".default-btn");
      allDefaultButtons.forEach((btn) => btn.classList.remove("selected"));

      // Add 'selected' class to the clicked button
      if (isSelected) {
        button.classList.remove("selected")
      } else {
        button.classList.add("selected");
      }

    });

    return button;
  };


  // Function to create the delete button
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

    // Change icon on hover
    button.addEventListener("mouseenter", () => {
      deleteImg.src = "../../assets/imgs/icons/trash-24x24-white.svg";
    });
    button.addEventListener("mouseleave", () => {
      deleteImg.src = "../../assets/imgs/icons/trash-24x24-red.svg";
    });

    // Remove card on delete
    button.addEventListener("click", (e) => {
      e.stopPropagation();
      card.remove();
      togglePlaceholder();
    });

    return button;
  };

  // Toggle placeholder visibility
  const togglePlaceholder = () => {
    placeholder.style.display = filesGallery.childElementCount ? "none" : "block";
  };

  // Drag-and-drop events
  ["dragenter", "dragover", "dragleave", "drop"].forEach((event) =>
    dropZone.addEventListener(event, (e) => {
      e.preventDefault();
      e.stopPropagation();
    })
  );

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