<?php
/**
 * GitHub Webhook → git pull + npm install + nuxt generate
 * Put this in the repo directory (same as .git and package.json).
 */

date_default_timezone_set('UTC');

// ===== CONFIG =====
$GITHUB_SECRET = '123asdjhjhj123123'; // EXACT same as GitHub webhook secret
$BRANCH        = 'main';               // Only deploy this branch
$APP_DIR       = __DIR__;              // Repo dir
$BUILD_CMD     = 'npm run generate';   // Nuxt static build
// ==================

$LOG_FILE  = __DIR__ . '/deploy.log';
$LOCK_FILE = __DIR__ . '/deploy.lock';

function logx($m){ global $LOG_FILE; file_put_contents($LOG_FILE,"[".date('Y-m-d H:i:s')."] $m\n",FILE_APPEND); }
function finish($m,$c=200){ http_response_code($c); echo $m."\n"; logx("RESP($c): $m"); exit; }

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') finish('Only POST',405);


$payload = file_get_contents('php://input');
$headers = function_exists('getallheaders') ? getallheaders() : [];

$sig256 = $headers['X-Hub-Signature-256'] ?? $headers['x-hub-signature-256'] ?? '';
$sig1   = $headers['X-Hub-Signature']     ?? $headers['x-hub-signature']     ?? '';

$calc256 = 'sha256=' . hash_hmac('sha256',$payload,$GITHUB_SECRET);
$calc1   = 'sha1='   . hash_hmac('sha1',  $payload,$GITHUB_SECRET);

// accept sha256 (preferred) or fallback to sha1 if needed
if (($sig256 && hash_equals($calc256,$sig256)) || ($sig1 && hash_equals($calc1,$sig1))) {
  // ok
} else {
  logx("BAD SIGNATURE sig256='$sig256' calc256='$calc256' sig1='$sig1' calc1='$calc1'");
  finish('Signature verification failed',401);
}

$data   = json_decode($payload,true) ?: [];
$ref    = $data['ref'] ?? '';
$branch = (strpos($ref,'refs/heads/')===0)?substr($ref,11):'';
if ($branch && $branch !== $BRANCH) finish("Ignored branch '$branch'",204);

$lock = fopen($LOCK_FILE,'c');
if (!$lock || !flock($lock,LOCK_EX|LOCK_NB)) finish('Busy, try later',429);

// Resolve paths for tools (helps on cPanel PATH)
function binpath($bin) {
  $p = trim(shell_exec("command -v $bin 2>/dev/null") ?? '');
  return $p ?: $bin; // fallback to name
}
$GIT = binpath('git');
$NPM = binpath('npm');

$repo = escapeshellarg($APP_DIR);

$cmds = [
  "cd $repo",
  "$GIT --version",
  "$NPM --version",
  "$GIT fetch --all --prune",
  "$GIT reset --hard origin/".escapeshellarg($BRANCH),
  "$NPM install --no-audit --no-fund",
  $BUILD_CMD,
  "echo Build finished at $(date)"
];

$full = implode(' && ',$cmds).' 2>&1';
logx("RUN:\n$full");
$out = shell_exec($full);
logx("OUT:\n".trim((string)$out));

finish("Deployed & built '$BRANCH'");