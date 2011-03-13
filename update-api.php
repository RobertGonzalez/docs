<?php
/**
 *
 * This file is part of the Aura project for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace aura\docs;

// get all repositories starting with 'aura.'
echo '[1/4] Retrieving the list of repositories to parse from Github.'.PHP_EOL;
$repositories = array();

// NOTE: this only retrieves the first 30 repositories: http://develop.github.com/p/repo.html
$repositories_source = json_decode(file_get_contents('http://github.com/api/v2/json/repos/show/auraphp'));
foreach($repositories_source->repositories as $repo)
{
  if (substr($repo->name, 0, 5) != 'aura.')
  {
    continue;
  }

  $repositories[$repo->name] = $repo->url;
}

echo '[2/4] Pulling all repositories.' . PHP_EOL;

// check if the base directory exists and otherwise create it
$base_repo_path = __DIR__ . DIRECTORY_SEPARATOR . 'repositories';
if (!file_exists($base_repo_path))
{
  mkdir($base_repo_path);
}

// foreach repository: if it exists locally: pull, if not: clone
foreach($repositories as $name => $repo)
{
  echo '        Retrieving: ' . $name . PHP_EOL;

  $command = file_exists($base_repo_path . DIRECTORY_SEPARATOR . $name)
    ? 'pull origin master'
    : "clone $repo $base_repo_path/$name";
  exec("git $command 2>&1", $output, $error);
  if ($error != 0)
  {
    echo implode(PHP_EOL, $output).PHP_EOL;
    exit(1);
  }
}

echo '[3/4] Building API documentation'.PHP_EOL;
$config_file = __DIR__.DIRECTORY_SEPARATOR.'docblox.config.xml';
$base_api_path = __DIR__.DIRECTORY_SEPARATOR.'api';
if (!file_exists($base_api_path))
{
  mkdir($base_api_path);
}
foreach ($repositories as $name => $repo)
{
  if (!file_exists($base_api_path.DIRECTORY_SEPARATOR.$name))
  {
    mkdir($base_api_path . DIRECTORY_SEPARATOR . $name);
  }

  echo '       Building: '.$name.PHP_EOL;
  echo '------------------------------------------------------'.PHP_EOL;
  passthru("../DocBlox/bin/docblox.php parse -c $config_file -d $base_repo_path/$name -t $base_api_path/$name --title=\"Aura Project for PHP: $name\"");
  passthru("../DocBlox/bin/docblox.php transform -s $base_api_path/$name/structure.xml -t $base_api_path/$name");
}

echo '[4/4] Generating custom index file in repositories/index.html' . PHP_EOL;

file_put_contents($base_api_path.DIRECTORY_SEPARATOR.'index.html', <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
  <head>
    <title>Aura project for PHP</title>
  </head>
  <frameset rows="30, *">
    <frame src="menu.html" scrolling="no" noresize="yes" frameborder="0">
    <frame src="aura.autoload/index.html" name="api_frame_content" frameborder="0">
  </frameset>
</html>
HTML
);

$menu = array();
foreach($repositories as $name => $repo)
{
  $menu[] = "<a href=\"$name/index.html\" target=\"api_frame_content\">$name</a>";
}
$menu = implode(' | ', $menu);

file_put_contents($base_api_path . DIRECTORY_SEPARATOR . 'menu.html', <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head></head>
  <body><div align="center">$menu</div></body>
</html>
HTML
);