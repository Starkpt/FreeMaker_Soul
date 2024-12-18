<?php

?>


<style>
  #drop-zone {
    transition: background-color 0.3s, border-color 0.3s;
    cursor: pointer;
  }

  #drop-zone.bg-light {
    background-color: #f8f9fa !important;
    /* Light gray */
  }

  #files-gallery .card {
    transition: transform 0.3s;
  }

  #files-gallery .card:hover {
    transform: scale(1.05);
  }

  .grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    /* Space between grid items */
    padding: 16px;
    /* Optional padding */
    background-color: #f9f9f9;
    /* Optional background */
    border: 1px solid #ddd;
    /* Optional border */
    border-radius: 8px;
  }


  .grid-item {
    background-color: #ffffff;
    padding: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
    font-size: 1.2rem;
    font-weight: bold;
  }
</style>

<div class="mb-3">
  <label for='fileInput' class="form-label">Imagens do produto</label>

  <div id="drop-zone-wrapper">
    <div id="drop-zone" class="border border-tertiary rounded-3 p-5 text-center"
      tabindex="0"
      role="region"
      aria-label="Drag and drop files"
      aria-describedby="upload-hint">
      <p id="upload-hint" class="text-body-tertiary m-0">
        Drag and drop files here, or browse
      </p>
      <input id="fileInput" type="file" class="d-none" aria-hidden="true" multiple />
      <div id="files-gallery" class="grid-container"></div>
    </div>
  </div>
</div>


<script>
  // References
  const dropZoneWrapper = document.querySelector("#drop-zone-wrapper")
  const dropZone = document.querySelector('#drop-zone');
  const fileInput = document.querySelector('#fileInput');
  const filesGallery = document.querySelector('#files-gallery');

  // Prevent default drag behaviors
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
    dropZone.addEventListener(event, e => {
      e.preventDefault();
      e.stopPropagation();
    });
  });

  // Highlight drop zone on drag
  ['dragenter', 'dragover'].forEach(event => {
    dropZone.addEventListener(event, () => {
      dropZone.classList.add('bg-light', 'border-success');
    });
  });

  ['dragleave', 'drop'].forEach(event => {
    dropZone.addEventListener(event, () => {
      dropZone.classList.remove('bg-light', 'border-success');
    });
  });

  // Handle dropped files
  dropZone.addEventListener('drop', e => {
    const files = [...e.dataTransfer.files];
    handleFiles(files);
  });

  // Trigger file input on zone click
  dropZoneWrapper.addEventListener("click", (e) => {
    fileInput.click()
  });

  // Handle file input change
  fileInput.addEventListener('change', e => {
    const files = [...e.target.files];
    handleFiles(files);
  });

  // Handle keyboard interactions
  dropZone.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault()
      fileInput.click();
    }
  });

  // Process and preview files
  function handleFiles(files) {
    files.forEach(file => {
      if (!file.type.startsWith('image/')) {
        alert(`${file.name} is not an image file.`);
        return;
      }

      const reader = new FileReader();
      reader.onload = e => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 grid-item';

        const card = document.createElement('div');
        card.className = 'card';

        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'card-img-top';
        img.alt = file.name;

        const cardBody = document.createElement('div');
        cardBody.className = 'card-body text-center p-2';

        const fileName = document.createElement('p');
        fileName.className = 'card-text text-truncate mb-2';
        fileName.textContent = file.name;

        const removeButton = document.createElement('button');
        removeButton.className = 'btn btn-sm btn-danger';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', () => {
          event.stopPropagation(); // Prevent the event from bubbling up to the parent
          col.remove()
        });

        cardBody.appendChild(fileName);
        cardBody.appendChild(removeButton);
        card.appendChild(img);
        card.appendChild(cardBody);
        col.appendChild(card);
        filesGallery.appendChild(col);
      };
      reader.readAsDataURL(file);
    });
  }
</script>