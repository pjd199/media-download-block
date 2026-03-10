import JSZip from 'jszip';

const initDownloadAll = () => {
    // Find all "Download All" buttons on the page
    const buttons = document.querySelectorAll('.mdb-download-all-btn');

    buttons.forEach(button => {
        // Prevent the script from attaching multiple times
        if (button.dataset.initialized) return;
        button.dataset.initialized = "true";

        button.addEventListener('click', async (e) => {
            e.preventDefault();

            // 1. Get the files from the data attribute (updated by PHP/Gutenberg)
            const filesData = button.getAttribute('data-files');
            if (!filesData) return;

            const files = JSON.parse(filesData);
            const zipName = button.getAttribute('data-zipname') || 'downloads';
            const zip = new JSZip();
            
            // 2. UI Feedback
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerText = 'Bundling Files...';

            try {
                // 3. Fetch all files simultaneously
                const promises = files.map(async (file) => {
                    const response = await fetch(file.url);
                    if (!response.ok) throw new Error(`Could not fetch ${file.url}`);
                    
                    const blob = await response.blob();
                    
                    // Use the custom Display Name from the sidebar, 
                    // falling back to the real filename if empty
                    const fileName = file.displayName ? 
                        `${file.displayName.replace(/[/\\?%*:|"<>]/g, '-')}.${file.fileLabel}` : 
                        file.realFileName;

                    zip.file(fileName, blob);
                });

                await Promise.all(promises);

                // 4. Generate and trigger download
                const content = await zip.generateAsync({ type: 'blob' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(content);
                link.download = `${zipName}.zip`;
                
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                button.innerHTML = originalText;
            } catch (error) {
                console.error('ZIP generation failed:', error);
                button.innerText = 'Error creating ZIP';
                setTimeout(() => { button.innerHTML = originalText; }, 3000);
            } finally {
                button.disabled = false;
            }
        });
    });
};

// Initialize on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDownloadAll);
} else {
    initDownloadAll();
}