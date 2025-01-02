<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blockchain Connect demo</title>
    <script src="https://cdn.jsdelivr.net/npm/web3@1.10.0/dist/web3.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
</head>
<body>
<!-- Button trigger modal -->
<div class="d-grid gap-2 col-6 mx-auto pt-4">
    <button type="button" id="ConnectButton" class="btn btn-primary btn-sm" data-bs-toggle="modal">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="visually-hidden">Loading...</span>
    </button>
</div>
<!-- Wallet Modal -->
<div class="modal fade" id="ConnectWallet" aria-hidden="true" aria-labelledby="ConnectWalletLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ConnectWalletLabel">Connect Wallet</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 pt-1">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-md-4 ms-auto d-grid">
                            <button type="button" class="btn border-0" id="MetaMaskButton" aria-label="Connect with MetaMask">
                                <svg width="35" height="35" class="bi mx-1 theme-icon-active">
                                    <use href="#MetaMask"></use>
                                </svg>
                                <p class="m-0" id="MetaMaskButtonP">MetaMask</p>
                            </button>
                        </div>
                        <div class="col-md-4 ms-auto d-grid">
                            <button type="button" class="btn disabled border-0" aria-disabled="true">
                                <svg width="35" height="35" class="bi mx-1 theme-icon-active">
                                    <use href="#BSC"></use>
                                </svg>
                                <p class="m-0">Binance Wallet</p>
                            </button>
                        </div>
                        <div class="col-md-4 ms-auto d-grid">
                            <button type="button" class="btn disabled border-0" aria-disabled="true">
                                <svg width="35" height="35" class="bi mx-1 theme-icon-active">
                                    <use href="#TrustWallet"></use>
                                </svg>
                                <p class="m-0">Trust Wallet</p>
                            </button>
                        </div>
                    </div>
                    <small class="text-danger fw-bold">
                        Keep your private keys and seed phrases secure. Never share them with anyone.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="NoExtensionFound" aria-hidden="true" aria-labelledby="NoExtensionFoundLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="NoExtensionFoundLabel2">No Extension Found!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <small>You have not yet installed the <b>Metamask</b> browser extension. Please go to the <b>Chrome/Firefox</b> Extension to proceed with the installation.</small>
                    <a class="btn btn-primary" role="button" href="https://metamask.io/download/" target="_blank">Install Extension</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="YourWallet" aria-hidden="true" aria-labelledby="YourWalletLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="YourWalletLabel">Your Wallet</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-text">Your Address</span>
                    <input type="text" class="form-control" aria-label="Your Address" readonly id="yourText1" placeholder="Loading...">
                </div>
                <div class="form-text d-flex">
                    <div class="me-auto">BNB Balance</div>
                    <div>0.01</div>
                </div>
            </div>
            <div class="d-grid gap-2 p-2 pt-0">
                <button type="button" class="btn btn-primary" disabled>
                    Disconnect Wallet
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ChangeNetwork" aria-hidden="true" aria-labelledby="ChangeNetwork" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ChangeNetwork">Wallet Network Doesn't Match</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <small>Your wallet network is set to <b>Ethereum (ID: 1)</b>, but you’re trying to use the application on <b>Holesky Test Network (ID: 17000)</b>.</small>
                    <button type="button" class="btn btn-primary" id="NetworkBu">
                        Change Wallet Network
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" role="img" aria-label="MetaMask Call Button" style="display: none">
    <symbol id="BSC" viewBox="0 0 225 225">
        <path stroke="null" fill="#F3BA2F" d="m224.20002,28.09998l36.6,0c9.3,0 16.1,2.5 20.5,6.8c4.3,3.7 6.2,8.7 6.2,13.6l0,0c0,1.9 0,4.3 -0.6,6.2c-1.2,3.1 -3.1,6.2 -5.6,8.7c-1.2,1.2 -2.5,1.9 -3.7,2.5c4.3,1.2 8.1,3.7 11.2,6.8c2.5,3.1 3.7,6.8 3.7,12.4l0,0c0,3.1 -0.6,6.8 -1.9,9.3c-1.2,2.5 -3.7,5 -6.2,6.8c-3.1,1.9 -6.2,3.1 -9.3,4.3c-3.7,1.2 -8.1,1.2 -12.4,1.2l-37.9,0l0,-78.8l-0.6,0l0,0.2zm33.5,32.2c3.1,0 6.2,-0.6 9.3,-1.9c2.5,-1.2 3.7,-3.7 3.7,-6.2l0,0c0,-2.5 -1.2,-5 -3.1,-6.2c-2.5,-1.9 -5.6,-2.5 -8.7,-1.9l-17.4,0l0,16.7l16.1,0l0,-0.5l0.1,0zm4.3,31.7c3.1,0 6.2,-0.6 9.3,-1.9c2.5,-1.2 3.7,-3.7 3.1,-6.8l0,0c0,-2.5 -1.2,-5 -3.1,-6.2c-1.9,-1.2 -5.6,-2.5 -9.9,-2.5l-20.5,0l0,17.4l21.1,0z" class="st0" id="svg_19"/>
        <polygon stroke="null" fill="#F3BA2F" points="314.1000061035156,28.099990844726562 331.5000305175781,28.099990844726562 331.5000305175781,107.49996948242188 314.1000061035156,107.49996948242188 " class="st0" id="svg_18"/>
        <polygon stroke="null" fill="#F3BA2F" points="358.2000427246094,28.099990844726562 374.3000183105469,28.099990844726562 411.5000305175781,77.10000610351562 411.5000305175781,28.099990844726562 428.8000183105469,28.099990844726562 428.8000183105469,107.49996948242188 414.0000305175781,107.49996948242188 374.8999938964844,57.19999694824219 374.8999938964844,107.49996948242188 358.2000427246094,107.49996948242188 " class="st0" id="svg_17"/>
        <path stroke="null" fill="#F3BA2F" d="m481.60002,27.49998l16.1,0l34.1,80l-18,0l-7.4,-18l-33.5,0l-7.4,18l-18,0l34.1,-80zm18.6,47.1l-10.5,-26l-10.5,26l21,0z" class="st0" id="svg_16"/>
        <polygon stroke="null" fill="#F3BA2F" points="550.4000244140625,28.099990844726562 566.5,28.099990844726562 603.7000732421875,77.10000610351562 603.7000732421875,28.099990844726562 621.0999755859375,28.099990844726562 621.0999755859375,107.49996948242188 606.2000122070312,107.49996948242188 567.7000732421875,57.19999694824219 567.7000732421875,107.49996948242188 550.4000244140625,107.49996948242188 " class="st0" id="svg_15"/>
        <path stroke="null" fill="#F3BA2F" d="m684.30002,108.69998c-5.6,0 -11.2,-1.2 -16.1,-3.1c-9.9,-4.3 -17.4,-11.8 -21.7,-21.7c-1.9,-5 -3.1,-10.5 -3.1,-16.1l0,0c0,-10.5 4.3,-21.1 11.8,-29.1c3.7,-3.7 8.1,-6.8 13,-8.7c5.6,-2.5 11.2,-3.1 16.7,-3.1c3.1,0 6.8,0 9.9,0.6c3.1,0.6 5.6,1.2 8.1,2.5c2.5,1.2 5,2.5 6.8,3.7c1.9,1.2 4.3,3.1 6.2,5l-10.5,13c-3.1,-2.5 -6.2,-5 -9.3,-6.8s-6.8,-2.5 -10.5,-2.5c-3.1,0 -6.2,0.6 -9.3,1.9c-3.1,1.2 -5.6,3.1 -7.4,5.6s-3.7,5 -5,8.1c-1.2,3.1 -1.9,6.2 -1.9,9.3l0,0c0,3.1 0.6,6.8 1.9,9.9s2.5,5.6 5,8.1c4.3,5 10.5,7.4 16.7,7.4c3.7,0 8.1,-0.6 11.8,-2.5c3.1,-1.9 6.8,-4.3 9.3,-6.8l11.1,11.1c-1.9,1.9 -4.3,4.3 -6.2,6.2c-2.5,1.9 -5,3.1 -7.4,4.3c-2.5,1.2 -5.6,2.5 -8.7,3.1c-4.4,0.6 -8.1,0.6 -11.2,0.6l0,0z" class="st0" id="svg_14"/>
        <polygon stroke="null" fill="#F3BA2F" points="737.7000732421875,28.099990844726562 797.2000122070312,28.099990844726562 797.2000122070312,43.59999084472656 754.4000244140625,43.59999084472656 754.4000244140625,59.69999694824219 792.2000122070312,59.69999694824219 792.2000122070312,75.20001220703125 754.4000244140625,75.20001220703125 754.4000244140625,92 797.800048828125,92 797.800048828125,107.49996948242188 737.7000732421875,107.49996948242188 " class="st0" id="svg_13"/>
        <path stroke="null" fill="#F3BA2F" d="m246.50002,185.59998c-4.3,0 -8.7,-0.6 -12.4,-2.5c-3.7,-1.2 -7.4,-3.7 -11.2,-6.8l6.2,-6.8c2.5,2.5 5,3.7 8.1,5.6c3.1,1.2 6.2,1.9 9.3,1.9c2.5,0 5,-0.6 7.4,-1.9c1.9,-1.2 2.5,-3.1 2.5,-5l0,0c0,-0.6 0,-1.9 -0.6,-2.5c-0.6,-0.6 -1.2,-1.9 -1.9,-2.5c-1.2,-0.6 -2.5,-1.2 -3.7,-1.9c-1.9,-0.6 -4.3,-1.2 -6.2,-1.9c-2.5,-0.6 -5.6,-1.2 -8.1,-2.5c-1.9,-0.6 -4.3,-1.9 -5.6,-3.1c-1.2,-1.2 -2.5,-2.5 -3.7,-4.3c-1.2,-2.5 -1.2,-5 -1.2,-6.8l0,0c0,-2.5 0.6,-4.3 1.2,-6.8c0.6,-1.9 2.5,-3.7 3.7,-5c1.9,-1.2 3.7,-2.5 6.2,-3.1c2.5,-0.6 5,-1.2 7.4,-1.2c3.7,0 7.4,0.6 11.2,1.9c3.1,1.2 6.2,3.1 9.3,5l-5,7.4c-2.5,-1.9 -5,-3.1 -7.4,-4.3c-2.5,-1.2 -5,-1.2 -7.4,-1.2c-2.5,0 -5,0.6 -6.8,1.9c-1.2,1.2 -2.5,3.1 -2.5,5l0,0c0,1.2 0,1.9 0.6,3.1c0.6,0.6 1.2,1.9 1.9,2.5c1.2,0.6 2.5,1.2 4.3,1.9c1.9,0.6 3.7,1.2 6.8,1.9c2.5,0.6 5,1.2 8.1,2.5c1.9,0.6 3.7,1.9 5.6,3.1c1.2,1.2 2.5,3.1 3.1,4.3c0.6,1.9 1.2,3.7 1.2,6.2l0,0c0,2.5 -0.6,5 -1.2,6.8c-1.2,1.9 -2.5,3.7 -4.3,5.6c-1.9,1.2 -3.7,2.5 -6.2,3.1c-3.1,-0.2 -6.2,0.4 -8.7,0.4z" class="st0" id="svg_12"/>
        <polygon stroke="null" fill="#F3BA2F" points="277.5000305175781,129.20001220703125 288.1000061035156,129.20001220703125 304.8000183105469,155.20001220703125 322.20001220703125,129.20001220703125 332.70001220703125,129.20001220703125 332.70001220703125,185 322.8000183105469,185 322.8000183105469,144.70001220703125 305.4000244140625,170.70001220703125 304.8000183105469,170.70001220703125 287.5000305175781,144.70001220703125 287.5000305175781,185 277.5000305175781,185 " class="st0" id="svg_11"/>
        <path stroke="null" fill="#F3BA2F" d="m366.20002,128.59998l9.3,0l24.2,55.8l-10.5,0l-5.6,-13.6l-26,0l-5.6,13.6l-9.9,0l24.1,-55.8zm14.3,34.1l-9.9,-22.3l-9.3,22.3l19.2,0z" class="st0" id="svg_10"/>
        <path stroke="null" fill="#F3BA2F" d="m409.60002,129.19998l24.8,0c3.1,0 6.2,0.6 9.3,1.2c2.5,0.6 5,2.5 6.8,4.3c1.2,1.2 2.5,3.1 3.7,5.6c0.6,1.9 1.2,4.3 1.2,6.8l0,0c0,1.9 -0.6,4.3 -1.2,6.2c-0.6,1.9 -1.9,3.1 -2.5,5c-1.2,1.2 -2.5,2.5 -4.3,3.7c-1.9,1.2 -3.7,1.9 -5.6,2.5l14.9,21.1l-11.8,0l-13.6,-19.2l-12.4,0l0,19.2l-9.9,0l0.6,-56.4zm24.2,27.3c3.1,0 6.2,-0.6 8.1,-2.5c1.9,-1.9 3.1,-4.3 3.1,-6.8l0,0c0,-2.5 -1.2,-5 -3.1,-6.8c-2.5,-1.9 -5.6,-2.5 -8.7,-2.5l-14.3,0l0,18.6l14.9,0z" class="st0" id="svg_9"/>
        <polygon stroke="null" fill="#F3BA2F" points="480.8999938964844,137.89996337890625 462.8999938964844,137.89996337890625 462.8999938964844,129.20001220703125 508.2000427246094,129.20001220703125 508.2000427246094,137.89996337890625 490.2000427246094,137.89996337890625 490.2000427246094,185 480.3000183105469,185 " class="st0" id="svg_8"/>
        <path stroke="null" fill="#F3BA2F" d="m568.40002,185.59998c-3.7,0 -7.4,-0.6 -11.2,-2.5c-6.8,-3.1 -12.4,-8.1 -14.9,-14.9c-1.2,-3.7 -2.5,-7.4 -1.9,-11.2l0,0c0,-3.7 0.6,-7.4 1.9,-11.2c2.5,-6.8 8.1,-12.4 14.9,-15.5c3.7,-1.2 7.4,-2.5 11.8,-2.5c2.5,0 5,0 6.8,0.6c1.9,0.6 3.7,1.2 5.6,1.9c1.9,0.6 3.1,1.9 5,2.5c1.2,1.2 3.1,2.5 4.3,3.7l-6.2,7.4c-1.9,-1.9 -4.3,-3.7 -6.8,-5c-2.5,-1.2 -5.6,-1.9 -8.7,-1.9c-2.5,0 -5,0.6 -7.4,1.2c-2.5,1.2 -4.3,2.5 -6.2,4.3c-1.9,1.9 -3.1,3.7 -3.7,6.2s-1.2,5 -1.2,7.4l0,0c0,2.5 0.6,5 1.2,7.4s1.9,4.3 3.7,6.2c1.9,1.9 3.7,3.1 6.2,4.3c2.5,1.2 5,1.9 7.4,1.2c3.1,0 6.2,-0.6 8.7,-1.9c2.5,-1.2 5,-3.1 7.4,-5.6l6.2,6.2c-1.2,1.2 -3.1,3.1 -4.3,4.3c-1.9,1.2 -3.1,2.5 -5,3.1c-1.9,0.6 -3.7,1.9 -6.2,1.9c-2.5,2.4 -5,2.4 -7.4,2.4l0,0z" class="st0" id="svg_7"/>
        <polygon stroke="null" fill="#F3BA2F" points="601.2000122070312,129.20001220703125 610.5,129.20001220703125 610.5,152.10000610351562 637.2000122070312,152.10000610351562 637.2000122070312,129.20001220703125 647.0999755859375,129.20001220703125 647.0999755859375,185 637.2000122070312,185 637.2000122070312,161.39996337890625 610.5,161.39996337890625 610.5,185 601.2000122070312,185 " class="st0" id="svg_6"/>
        <path stroke="null" fill="#F3BA2F" d="m681.20002,128.59998l9.3,0l24.2,55.8l-10.5,0l-5.6,-13.6l-26,0l-5.6,13.6l-9.9,0l24.1,-55.8zm13.7,34.1l-9.3,-22.3l-9.3,22.3l18.6,0z" class="st0" id="svg_5"/>
        <polygon stroke="null" fill="#F3BA2F" points="724.6000366210938,129.20001220703125 734.6000366210938,129.20001220703125 734.6000366210938,185 724.6000366210938,185 " class="st0" id="svg_4"/>
        <polygon stroke="null" fill="#F3BA2F" points="749.4000244140625,129.20001220703125 758.0999755859375,129.20001220703125 787.8999633789062,167.5999755859375 787.8999633789062,129.20001220703125 797.800048828125,129.20001220703125 797.800048828125,185 789.7000732421875,185 759.4000244140625,145.29998779296875 759.4000244140625,185 749.4000244140625,185 " class="st0" id="svg_3"/>
        <path stroke="null" fill="#F3BA2F" d="m115.10002,181.29998l0,24.2l-21.1,12.4l-20.5,-12.4l0,-24.2l20.5,12.4l21.1,-12.4zm-112.9,-83.7l20.5,12.4l0,41.5l35.3,21.1l0,24.2l-55.8,-32.9l0,-66.3zm183.6,0l0,66.4l-56.4,32.9l0,-24.2l35.3,-21.1l0,-41.5l21.1,-12.5zm-56.5,-32.9l21.1,12.4l0,0l0,24.2l-35.3,21.1l0,42.1l-20.5,12.4l-20.4,-12.4l0,-42.2l-36.6,-21.1l0,-24.2l21.1,-12.4l35.3,21.1l35.3,-21zm-91.7,53.9l20.5,12.4l0,24.2l-20.5,-12.4l0,-24.2zm112.8,0l0,24.2l-20.5,12.4l0,-24.2l20.5,-12.4zm-127.7,-75l21.1,12.4l-21.1,12.4l0,24.2l-20.5,-12.4l0,-24.2l20.5,-12.4zm142.6,0l21.1,12.4l0,24.2l-21.1,12.4l0,-24.2l-20.5,-12.4l20.5,-12.4zm-71.3,0l21.1,12.4l-21.1,12.4l-20.5,-12.4l20.5,-12.4zm0,-41.5l56.4,32.9l-20.5,12.4l-35.3,-21.1l-36,21.1l-20.5,-12.4l55.9,-32.9z" class="st0" id="svg_2"/>
    </symbol>
    <symbol id="MetaMask" viewBox="0 0 318.6 318.6">
        <title>MetaMask</title>
        <style>
            .st1,.st6{fill:#e4761b;stroke:#e4761b;stroke-linecap:round;stroke-linejoin:round}.st6{fill:#f6851b;stroke:#f6851b}
        </style>
        <path fill="#e2761b" stroke="#e2761b" stroke-linecap="round" stroke-linejoin="round" d="m274.1 35.5-99.5 73.9L193 65.8z"/>
        <path d="m44.4 35.5 98.7 74.6-17.5-44.3zm193.9 171.3-26.5 40.6 56.7 15.6 16.3-55.3zm-204.4.9L50.1 263l56.7-15.6-26.5-40.6z" class="st1"/>
        <path d="m103.6 138.2-15.8 23.9 56.3 2.5-2-60.5zm111.3 0-39-34.8-1.3 61.2 56.2-2.5zM106.8 247.4l33.8-16.5-29.2-22.8zm71.1-16.5 33.9 16.5-4.7-39.3z" class="st1"/>
        <path fill="#d7c1b3" stroke="#d7c1b3" stroke-linecap="round" stroke-linejoin="round" d="m211.8 247.4-33.9-16.5 2.7 22.1-.3 9.3zm-105 0 31.5 14.9-.2-9.3 2.5-22.1z"/>
        <path fill="#233447" stroke="#233447" stroke-linecap="round" stroke-linejoin="round" d="m138.8 193.5-28.2-8.3 19.9-9.1zm40.9 0 8.3-17.4 20 9.1z"/>
        <path fill="#cd6116" stroke="#cd6116" stroke-linecap="round" stroke-linejoin="round" d="m106.8 247.4 4.8-40.6-31.3.9zM207 206.8l4.8 40.6 26.5-39.7zm23.8-44.7-56.2 2.5 5.2 28.9 8.3-17.4 20 9.1zm-120.2 23.1 20-9.1 8.2 17.4 5.3-28.9-56.3-2.5z"/>
        <path fill="#e4751f" stroke="#e4751f" stroke-linecap="round" stroke-linejoin="round" d="m87.8 162.1 23.6 46-.8-22.9zm120.3 23.1-1 22.9 23.7-46zm-64-20.6-5.3 28.9 6.6 34.1 1.5-44.9zm30.5 0-2.7 18 1.2 45 6.7-34.1z"/>
        <path d="m179.8 193.5-6.7 34.1 4.8 3.3 29.2-22.8 1-22.9zm-69.2-8.3.8 22.9 29.2 22.8 4.8-3.3-6.6-34.1z" class="st6"/>
        <path fill="#c0ad9e" stroke="#c0ad9e" stroke-linecap="round" stroke-linejoin="round" d="m180.3 262.3.3-9.3-2.5-2.2h-37.7l-2.3 2.2.2 9.3-31.5-14.9 11 9 22.3 15.5h38.3l22.4-15.5 11-9z"/>
        <path fill="#161616" stroke="#161616" stroke-linecap="round" stroke-linejoin="round" d="m177.9 230.9-4.8-3.3h-27.7l-4.8 3.3-2.5 22.1 2.3-2.2h37.7l2.5 2.2z"/>
        <path fill="#763d16" stroke="#763d16" stroke-linecap="round" stroke-linejoin="round" d="m278.3 114.2 8.5-40.8-12.7-37.9-96.2 71.4 37 31.3 52.3 15.3 11.6-13.5-5-3.6 8-7.3-6.2-4.8 8-6.1zM31.8 73.4l8.5 40.8-5.4 4 8 6.1-6.1 4.8 8 7.3-5 3.6 11.5 13.5 52.3-15.3 37-31.3-96.2-71.4z"/>
        <path d="m267.2 153.5-52.3-15.3 15.9 23.9-23.7 46 31.2-.4h46.5zm-163.6-15.3-52.3 15.3-17.4 54.2h46.4l31.1.4-23.6-46zm71 26.4 3.3-57.7 15.2-41.1h-67.5l15 41.1 3.5 57.7 1.2 18.2.1 44.8h27.7l.2-44.8z" class="st6"/>
    </symbol>
    <symbol id="TrustWallet" viewBox="0 0 64 64">
        <path d="M32.3999 64C50.073 64 64.3999 49.6731 64.3999 32C64.3999 14.3269 50.073 0 32.3999 0C14.7268 0 0.399902 14.3269 0.399902 32C0.399902 49.6731 14.7268 64 32.3999 64Z" fill="#3375BB"/>
        <path d="M32.6267 14C38.9508 19.2816 46.2029 18.9559 48.275 18.9559C47.8217 48.9937 44.3683 43.0373 32.6267 51.46C20.8851 43.0373 17.4533 48.9937 17 18.9559C19.0505 18.9559 26.3026 19.2816 32.6267 14Z" stroke="white" stroke-width="4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
</svg>


<div class="container">
  <h1>Smart Contract Interaction with Whitechain</h1>

  <!-- Set Data Form -->
  <form id="setForm">
      <div class="mb-3">
          <label for="exampleInputid" class="form-label">ID</label>
          <input type="text" class="form-control" id="exampleInputid" required>
          <div class="form-text">Enter an ID.</div>
      </div>
      <div class="mb-3">
          <label for="exampleInputname" class="form-label">Name</label>
          <input type="text" class="form-control" id="exampleInputname" required>
          <div class="form-text">Enter a name.</div>
      </div>
      <div class="mb-3">
          <label for="exampleInputdata" class="form-label">Data</label>
          <input type="text" class="form-control" id="exampleInputdata" required>
          <div class="form-text">Enter data.</div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  <!-- Get Data Form -->
  <form id="getForm" class="pt-5">
      <div class="mb-3">
          <label for="getinfo" class="form-label">Info</label>
          <input type="text" class="form-control" id="getinfo" required>
          <div class="form-text">Enter the ID to retrieve information.</div>
      </div>
      <button type="submit" class="btn btn-primary">Get Info</button>
  </form>

  <!-- Result Display -->
  <div class="mt-4" id="result"></div>
</div>

<script>
  const contractABI = [
      {
          "inputs": [{ "internalType": "string", "name": "_id", "type": "string" }],
          "name": "get",
          "outputs": [
              { "internalType": "string", "name": "name", "type": "string" },
              { "internalType": "string", "name": "data", "type": "string" }
          ],
          "stateMutability": "view",
          "type": "function"
      },
      {
          "inputs": [
              { "internalType": "string", "name": "_id", "type": "string" },
              { "internalType": "string", "name": "_name", "type": "string" },
              { "internalType": "string", "name": "_data", "type": "string" }
          ],
          "name": "set",
          "outputs": [],
          "stateMutability": "nonpayable",
          "type": "function"
      }
  ];
  const contractAddress = "0xc6e7DF5E7b4f2A278906862b61205850344D4e7d";
  const web3 = new Web3(window.ethereum);
  const contract = new web3.eth.Contract(contractABI, contractAddress);

  // Handle set form submission
  document.getElementById("setForm").addEventListener("submit", async (event) => {
      event.preventDefault();

      const id = document.getElementById("exampleInputid").value;
      const name = document.getElementById("exampleInputname").value;
      const data = document.getElementById("exampleInputdata").value;

      try {
          // Request accounts from MetaMask
          const accounts = await ethereum.request({ method: "eth_requestAccounts" });

          // Prepare the transaction data
          const tx = {
              from: accounts[0],
              to: contractAddress,
              data: contract.methods.set(id, name, data).encodeABI(),
              gas: 2000000,  // Adjust the gas limit
              gasPrice: web3.utils.toWei('20', 'gwei'),  // Set the gas price manually
          };

          // Send the transaction
          await web3.eth.sendTransaction(tx);
          alert("Data successfully stored!");
      } catch (error) {
          console.error(error);
          alert("Failed to store data.");
      }
  });

  // Handle get form submission
  document.getElementById("getForm").addEventListener("submit", async (event) => {
      event.preventDefault();

      const id = document.getElementById("getinfo").value;

      try {
          // Call the smart contract's get function
          const result = await contract.methods.get(id).call();
          
          // Display the result
          document.getElementById("result").innerHTML = `<p>Name: ${result.name}</p><p>Data: ${result.data}</p>`;
      } catch (error) {
          console.error(error);
          alert("Failed to retrieve data.");
      }
  });
</script>







<script>
  const BSC_CHAIN_ID = "0xA41";
  const BSC_DETAILS = {
      chainId: BSC_CHAIN_ID,
      chainName: "Whitechain Testnet",
      rpcUrls: ["https://rpc-testnet.whitechain.io"],  // Holesky RPC URL
      nativeCurrency: {
          name:"WBT",
          symbol: "WBT",
          decimals: 18
      },
      blockExplorerUrls: ["testnet.whitechain.io"]  // Holesky block explorer URL
  };
  const ABI=[
{
  "inputs": [
    {
      "internalType": "string",
      "name": "_id",
      "type": "string"
    }
  ],
  "name": "get",
  "outputs": [
    {
      "internalType": "string",
      "name": "name",
      "type": "string"
    },
    {
      "internalType": "string",
      "name": "data",
      "type": "string"
    }
  ],
  "stateMutability": "view",
  "type": "function"
},
{
  "inputs": [
    {
      "internalType": "string",
      "name": "_id",
      "type": "string"
    },
    {
      "internalType": "string",
      "name": "_name",
      "type": "string"
    },
    {
      "internalType": "string",
      "name": "_data",
      "type": "string"
    }
  ],
  "name": "set",
  "outputs": [],
  "stateMutability": "nonpayable",
  "type": "function"
}
];
//const contractAddress = "0xc6e7DF5E7b4f2A278906862b61205850344D4e7d"; // wait to send it 
//const web32 = new Web3(window.ethereum);

// Initialize the contract
//const contract2 = new web32.eth.Contract(ABI, contractAddress);
  const ERROR_CODE_NETWORK_NOT_ADDED = 4902;
  const connectButton = document.getElementById('ConnectButton');
  const metaMaskButton = document.getElementById('MetaMaskButton');
  const noExtensionFoundModal = document.getElementById('NoExtensionFound');
  const yourAddressInput = document.getElementById('yourText1');
  const NetworkBu = document.getElementById('NetworkBu');
  // Utility to update button
  function updateButton(targetModal, buttonText, spinnerColor) {
      connectButton.setAttribute('data-bs-target', targetModal);
      connectButton.innerHTML = `<span class="spinner-grow spinner-grow-sm ${spinnerColor}" role="status"></span> ${buttonText}`;
  }
  // Handle network switch button click
  NetworkBu.onclick = async () => {
      NetworkBu.disabled = true;
      NetworkBu.innerHTML = `<span class="spinner-border spinner-border-sm"></span>`;

      try {
          await ethereum.request({
              method: 'wallet_switchEthereumChain',
              params: [{ chainId: BSC_CHAIN_ID }]
          });
          const accounts = await ethereum.request({ method: 'eth_accounts' });
          if (yourAddressInput) yourAddressInput.value = accounts[0];
          updateButton('#YourWallet', `0x${accounts[0].slice(0, 6)}...${accounts[0].slice(-4)}`, 'text-success');
      } catch (switchError) {
          if (switchError.code === ERROR_CODE_NETWORK_NOT_ADDED) {
              try {
                  await ethereum.request({
                      method: 'wallet_addEthereumChain',
                      params: [BSC_DETAILS]
                  });
                  NetworkBu.innerHTML = `Network Added Successfully`;
              } catch (addError) {
                  console.error('Failed to add BSC network:', addError);
                  NetworkBu.disabled = false;
                  NetworkBu.innerHTML = `Failed to Add Network`;
              }
          } else {
              console.error('Network switch failed:', switchError);
              NetworkBu.disabled = false;
              NetworkBu.innerHTML = `Retry Switch Network`;
          }
      }
  };
  // Handle MetaMask connect button click
  async function onClickConnect() {
      if (typeof window.ethereum === 'undefined') {
          new bootstrap.Modal(noExtensionFoundModal).show();
          return;
      }

      metaMaskButton.disabled = true;
      document.getElementById('MetaMaskButtonP').innerHTML = `<span class="spinner-border spinner-border-sm"></span>`;

      try {
          await ethereum.request({ method: 'eth_requestAccounts' });
          const chainId = await ethereum.request({ method: 'eth_chainId' });
          const accounts = await ethereum.request({ method: 'eth_accounts' });

          if (accounts.length === 0) {
              alert('No accounts found. Please log in to your wallet.');
              metaMaskButton.disabled = false;
              document.getElementById('MetaMaskButtonP').innerHTML = `MetaMask`;
              return;
          }

          if (chainId === BSC_CHAIN_ID) {
              updateButton('#YourWallet', `0x${accounts[0].slice(0, 6)}...${accounts[0].slice(-4)}`, 'text-success');
              if (yourAddressInput) yourAddressInput.value = accounts[0];
          } else {
              updateButton('#ChangeNetwork', 'Switch Network', 'text-danger');
              document.getElementById('MetaMaskButtonP').innerHTML = `Connected`;
          }
      } catch (error) {
          console.error('Error during wallet connection:', error);
          metaMaskButton.disabled = false;
          document.getElementById('MetaMaskButtonP').innerHTML = `MetaMask`;
      }
  }
  // Initialization function to set up the button states
  async function initialize() {
      connectButton.innerHTML = '<span class="spinner-grow spinner-grow-sm text-secondary"></span> Connect Wallet';
      connectButton.setAttribute('data-bs-target', '#ConnectWallet');
      metaMaskButton.onclick = onClickConnect;

      if (typeof window.ethereum === 'undefined') {
          console.warn('Ethereum provider is not available.');
          return;
      }

      try {
          const accounts = await ethereum.request({ method: 'eth_accounts' });
          const chainId = await ethereum.request({ method: 'eth_chainId' });

          if (accounts.length > 0) {
              if (chainId === BSC_CHAIN_ID) {
                  updateButton('#YourWallet', `0x${accounts[0].slice(0, 6)}...${accounts[0].slice(-4)}`, 'text-success');
                  if (yourAddressInput) yourAddressInput.value = accounts[0];
              } else {
                  updateButton('#ChangeNetwork', 'Switch Network', 'text-danger');
              }
          } else {
              connectButton.setAttribute('data-bs-target', '#ConnectWallet');
          }
      } catch (error) {
          console.error('Error during initialization:', error);
      }
  }
  window.addEventListener('DOMContentLoaded', initialize);

</script>


















<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>