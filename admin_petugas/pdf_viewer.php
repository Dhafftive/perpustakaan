<!DOCTYPE html>
<html>
<head>
    <title>PDF Viewer</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
    <style>
        body{
            background-color: #1a1a1a;
        }
        /* CSS untuk kontainer PDF Viewer */
        #pdfViewer {
            margin: 20px auto;
            max-width: 800px;
            background-color: #FFB000;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* CSS untuk elemen canvas */
        canvas {
            display: block;
            margin: 10px auto;
            border: 1px solid #ccc;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        /* CSS untuk pesan kesalahan */
        #errorMsg {
            color: red;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="pdfViewer"></div>

    <script>
        // Ambil buku ID dari parameter URL
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const bookId = urlParams.get('id');

        // Kirim permintaan HTTP ke PHP untuk mendapatkan konten buku
        fetch(`function/baca_buku.php?id=${bookId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error, status = ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Gunakan konten buku untuk menampilkan PDF
                const pdfUrl = `../books-library/${data}`;

                const pdfjsLib = window['pdfjs-dist/build/pdf'];
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

                pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                // Mengambil jumlah total halaman PDF
                const numPages = pdf.numPages;

                // Menggunakan loop untuk menampilkan semua halaman
                for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                    pdf.getPage(pageNum).then(page => {
                        const scale = 1.5;
                        const viewport = page.getViewport({ scale });
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        page.render(renderContext);
                        document.getElementById('pdfViewer').appendChild(canvas);
                    });
                }
            }).catch(error => console.error('Error:', error.message));

            })
            .catch(error => console.error('Error:', error.message));
    </script>
</body>
</html>
