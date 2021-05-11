<script>
Start();
function Start(){
    document.getElementById('scan_barcode').addEventListener('click', () => {
          if (navigator.serial) {
            connectSerial();
          } else {
            alert('Web Serial API not supported.');
          }
        });
        async function connectSerial() {
          const log = document.getElementById('target');

          try {
            const port = await navigator.serial.requestPort();
            await port.open({ baudrate: 9600 });

            const decoder = new TextDecoderStream();

            port.readable.pipeTo(decoder.writable);

            const inputStream = decoder.readable;
            const reader = inputStream.getReader();

            while (true) {
              const { value, done } = await reader.read();
              if (value) {
                log.textContent += value + '\n';
              }
              if (done) {
                console.log('[readLoop] DONE', done);
                reader.releaseLock();
                break;
              }
            }

          } catch (error) {
            log.innerHTML = error;
          }
        }
        }
</script>