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
  }

  #drop-zone.bg-light {
    background-color: #f8f9fa !important;
    border-color: #28a745;
    /* Success green border */
  }

  #files-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 16px;
  }

  .card {
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
    overflow: hidden;
  }

  .card:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .card img {
    width: 100%;
    height: auto;
  }

  #placeholder-message {
    margin: 0;
    font-size: 1rem;
    color: #888;
  }
</style>

<div class="mb-3">
  <label for="fileInput" class="form-label">Imagens do produto</label>

  <div id="drop-zone-wrapper">
    <div
      id="drop-zone"
      tabindex="0"
      role="region"
      aria-label="Drag and drop files or click to upload"
      aria-describedby="upload-hint">
      <p id="placeholder-message" class="text-center">No files uploaded yet.</p>
      <input id="fileInput" type="file" class="d-none" aria-hidden="true" multiple />
      <div id="files-gallery"></div>
    </div>
  </div>
  <small class="text-tertiary">The first image will be the default image to be shown</small>
</div>

<script>
  const dropZone = document.querySelector('#drop-zone');
  const fileInput = document.querySelector('#fileInput');
  const filesGallery = document.querySelector('#files-gallery');
  const placeholder = document.querySelector('#placeholder-message');

  // Prevent default drag behaviors
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event =>
    dropZone.addEventListener(event, e => {
      e.preventDefault();
      e.stopPropagation();
    })
  );

  // Highlight drop zone on drag
  dropZone.addEventListener('dragenter', () => dropZone.classList.add('bg-light'));
  dropZone.addEventListener('dragleave', () => dropZone.classList.remove('bg-light'));
  dropZone.addEventListener('drop', () => dropZone.classList.remove('bg-light'));

  // Handle file input and drop
  const handleFiles = files => {
    files.forEach(file => {
      if (!file.type.startsWith('image/')) {
        alert(`"${file.name}" is not an image file.`);
        return;
      }

      const reader = new FileReader();
      reader.onload = () => {
        const card = document.createElement('div');
        card.className = 'card';

        const img = document.createElement('img');
        img.src = reader.result;
        img.alt = file.name;

        const cardBody = document.createElement('div');
        cardBody.className = 'card-body';

        const fileName = document.createElement('p');
        fileName.textContent = file.name;
        fileName.className = 'card-text text-truncate mb-2';

        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.className = 'btn btn-sm btn-danger';
        removeButton.addEventListener('click', e => {
          e.stopPropagation(); // Prevent the event from bubbling to the drop zone
          card.remove();
          togglePlaceholder();
        });

        cardBody.appendChild(fileName);
        cardBody.appendChild(removeButton);
        card.appendChild(img);
        card.appendChild(cardBody);
        filesGallery.appendChild(card);

        // Stop propagation of any clicks on the card or its elements
        card.addEventListener('click', e => e.stopPropagation());
        togglePlaceholder();
      };
      reader.readAsDataURL(file);
    });
  };

  const togglePlaceholder = () => {
    placeholder.style.display = filesGallery.childElementCount ? 'none' : 'block';
  };

  dropZone.addEventListener('click', () => fileInput.click());
  dropZone.addEventListener('drop', e => handleFiles([...e.dataTransfer.files]));
  fileInput.addEventListener('change', e => handleFiles([...e.target.files]));

  dropZone.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      fileInput.click();
    }
  });
</script>