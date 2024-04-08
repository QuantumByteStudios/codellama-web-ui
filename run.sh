#!/bin/bash

# Function to log messages
log() {
    echo "$(date +'%Y-%m-%d %H:%M:%S') - $1"
}

# Check if PHP is installed
if ! command -v php &>/dev/null; then
    log "ERROR: PHP is not installed. Please install PHP before running this script."
    exit 1
fi

# Check if Ollama is installed
if ! command -v ollama &>/dev/null; then
    log "ERROR: Ollama is not installed. Please install Ollama before running this script."
    exit 1
fi

# Navigate to the directory of the script
cd "$(dirname "$0")" || exit
log "INFO: Script directory: $(pwd)"

# Fetch updates from the Git repository
log "INFO: Fetching updates from the Git repository..."
git fetch

# Check if updates are available
if [[ $(git rev-parse HEAD) != $(git rev-parse @{u}) ]]; then
    # Pull updates from the Git repository if available
    log "INFO: Updates available. Pulling..."
    git pull
else
    # No updates available
    log "INFO: Already up to date."
fi

# Clear the terminal screen
clear

# Start the PHP development server
log "INFO: Starting PHP development server..."
php -S localhost:8000 &

# Log the server start
log "INFO: PHP development server started on http://localhost:8000"

# Open the URL in the default browser
log "INFO: Opening URL in default browser..."
case "$(uname -s)" in
Darwin) open http://localhost:8000 ;;
Linux) xdg-open http://localhost:8000 ;;
CYGWIN* | MINGW32* | MSYS* | MINGW*) start http://localhost:8000 ;;
*) log "ERROR: Unsupported operating system." ;;
esac
