FROM node:18-bookworm

RUN apt-get update && apt-get install -y \
    git \
    jq \
    curl \
    php-cli \
    grep \
    sed \
    && rm -rf /var/lib/apt/lists/*

RUN npm install -g @anthropic-ai/claude-code

USER node
WORKDIR /workspace
