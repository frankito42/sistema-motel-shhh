document.addEventListener("DOMContentLoaded", () => {
	
	Quagga.init({
		inputStream: {
			constraints: {
				width: 1920,
				height: 1080,
			},
			name: "Live",
			type: "LiveStream",
			target: document.querySelector('#contenedor')    // Or '#yourElement' (optional)
		},
		decoder: {
			readers: [{
				format: "ean_reader",
				config: {
					supplements: [
						'ean_5_reader', 'ean_13_reader'
					]
				}
			}]
		}
	}, function (err) {
		if (err) {
			console.log(err);
			return
		}
		console.log("Initialization finished. Ready to start");
		Quagga.start();
	});

	Quagga.onDetected((data) => {
		console.log(data)
		/* if (data.codeResult.startInfo.error<0.00000000000001) {
			document.getElementById("codigo").value=data.codeResult.code
			Quagga.stop()
		} */

		let resultCollector = Quagga.ResultCollector.create({
			capture: true, // keep track of the image producing this result
			capacity: 20,  // maximum number of results to store
			blacklist: [   // list containing codes which should not be recorded
				{code: data.codeResult.code, format: "ean_13"}],
			filter: function(codeResult) {
				// only store results which match this constraint
				// returns true/false
				console.log(codeResult)
				// e.g.: return codeResult.format === "ean_13";
				/* return true */;
			}
		});
		console.log(resultCollector)



		/* if(window.wopener){
			window.opener.onCodigoLeido(data);
			window.close();
		} */
	});

	Quagga.onProcessed(function (result) {
		var drawingCtx = Quagga.canvas.ctx.overlay,
			drawingCanvas = Quagga.canvas.dom.overlay;

		if (result) {
			if (result.boxes) {
				drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
				result.boxes.filter(function (box) {
					return box !== result.box;
				}).forEach(function (box) {
					Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
				});
			}

			if (result.box) {
				Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
			}

			if (result.codeResult && result.codeResult.code) {
				Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
			}
		}
	});
});