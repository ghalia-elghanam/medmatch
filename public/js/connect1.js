
const BSC_CHAIN_ID = "0xA41";
const BSC_DETAILS = {
    chainId: BSC_CHAIN_ID,
    chainName: "Whitechain Testnet",
    rpcUrls: ["https://rpc-testnet.whitechain.io"], 
    nativeCurrency: {
        name:"WBT",
        symbol: "WBT",
        decimals: 18
    },
    blockExplorerUrls: ["testnet.whitechain.io"]  
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



