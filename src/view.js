import JSZip from 'jszip';

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.mdb-download-all-btn');

    buttons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const files = JSON.parse(button.dataset.files);
            const zipName = button.dataset.zipname || 'downloads';
            const zip = new JSZip();
            
            button.innerText = 'Preparing ZIP...';
            button.disabled = true;

            try {
                const promises = files.map(async (file) => {
                    const response = await fetch(file.url);
                    const blob = await response.blob();
                    // Use the original filename or the display name
                    const name = file.realFileName || `${file.displayName}.${file.fileLabel.toLowerCase()}`;
                    zip.file(name, blob);
                });

                await Promise.all(promises);
                const content = await zip.generateAsync({ type: 'blob' });
                
                // Create temporary link to trigger download
                const link = document.createElement('a');
                link.href = URL.createObjectURL(content);
                link.download = `${zipName}.zip`;
                link.click();
                
                button.innerText = 'Download All (.zip)';
            } catch (error) {
                console.error('Zip failed', error);
                button.innerText = 'Error Downloading';
            } finally {
                button.disabled = false;
            }
        });
    });
});