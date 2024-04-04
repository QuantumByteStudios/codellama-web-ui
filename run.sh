#!/bin/bash

# Check if PHP is installed
if ! command -v php &> /dev/null
then
    echo "PHP is not installed. Please install PHP before running this script."
    exit 1
fi

# Check if Ollama is installed
if ! command -v ollama &> /dev/null
then
    echo "Ollama is not installed. Please install Ollama before running this script."
    exit 1
fi

# Navigate to the directory of the script
cd "$(dirname "$0")" || exit

# Fetch updates from the Git repository
git fetch

# Check if updates are available
if [[ $(git rev-parse HEAD) != $(git rev-parse @{u}) ]]; then
    # Pull updates from the Git repository if available
    echo "Updates available. Pulling..."
    git pull
else
    # No updates available, proceed to clear the terminal screen and start the PHP development server
    echo "Already up to date."
fi

# Clear the terminal screen
clear

# Start the PHP development server
php -S localhost:8000
