#!/bin/bash
# Ralph Loop — Gestou GCP Migration
# Uso: ./ralph.sh [max_iterations]
# Exemplo: ./ralph.sh 15

set -e

MAX_ITERATIONS=${1:-15}
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PRD_FILE="$SCRIPT_DIR/prd.json"
PROGRESS_FILE="$SCRIPT_DIR/progress.txt"

# Verificações
if [ ! -f "$PRD_FILE" ]; then
  echo "❌ prd.json não encontrado em $SCRIPT_DIR"
  exit 1
fi

if ! command -v jq &> /dev/null; then
  echo "❌ jq não instalado. Rode: brew install jq (mac) ou sudo apt install jq (linux)"
  exit 1
fi

if ! command -v claude &> /dev/null; then
  echo "❌ Claude Code não instalado. Rode: npm install -g @anthropic-ai/claude-code"
  exit 1
fi

# Inicializar progress.txt se não existe
if [ ! -f "$PROGRESS_FILE" ]; then
  echo "# Ralph Progress Log" > "$PROGRESS_FILE"
  echo "Started: $(date)" >> "$PROGRESS_FILE"
  echo "---" >> "$PROGRESS_FILE"
fi

# Status inicial
TOTAL=$(jq '.userStories | length' "$PRD_FILE")
DONE=$(jq '[.userStories[] | select(.passes == true)] | length' "$PRD_FILE")
echo ""
echo "🔁 Ralph Gestou Migration"
echo "   Total de stories: $TOTAL"
echo "   Completas: $DONE"
echo "   Pendentes: $((TOTAL - DONE))"
echo "   Max iterações: $MAX_ITERATIONS"
echo ""

for i in $(seq 1 $MAX_ITERATIONS); do
  # Status atualizado
  DONE=$(jq '[.userStories[] | select(.passes == true)] | length' "$PRD_FILE")
  NEXT=$(jq -r '[.userStories[] | select(.passes == false)] | sort_by(.priority) | .[0] | "\(.id) - \(.title)"' "$PRD_FILE")

  echo "==========================================="
  echo "  Iteração $i/$MAX_ITERATIONS | Completas: $DONE/$TOTAL"
  echo "  Próxima: $NEXT"
  echo "==========================================="

  # Rodar Claude Code com o CLAUDE.md como prompt
  OUTPUT=$(claude --dangerously-skip-permissions --print < "$SCRIPT_DIR/CLAUDE.md" 2>&1 | tee /dev/stderr) || true

  # Checar completion
  if echo "$OUTPUT" | grep -q "<promise>COMPLETE</promise>"; then
    echo ""
    echo "✅ Ralph completou TODAS as tarefas!"
    echo "   Iterações usadas: $i de $MAX_ITERATIONS"
    echo ""
    echo "📋 Próximos passos:"
    echo "   git log --oneline -20"
    echo "   git diff main...migration/gcp --stat"
    exit 0
  fi

  echo ""
  echo "Iteração $i completa. Aguardando 3s..."
  sleep 3
done

echo ""
echo "⚠️  Ralph atingiu o limite de $MAX_ITERATIONS iterações."
DONE=$(jq '[.userStories[] | select(.passes == true)] | length' "$PRD_FILE")
echo "   Completas: $DONE/$TOTAL"
echo "   Verifique: cat progress.txt"
echo "   Pendentes: cat prd.json | jq '.userStories[] | select(.passes == false) | {id, title}'"
exit 1