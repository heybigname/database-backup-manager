<?php namespace BackupManager\Tasks\Compression;

use Symfony\Component\Process\Process;
use BackupManager\ShellProcessing\ShellProcessFailed;
use BackupManager\Tasks\Task;
use BackupManager\Compressors\Compressor;
use BackupManager\ShellProcessing\ShellProcessor;

/**
 * Class DecompressFile
 * @package BackupManager\Tasks\Compression
 */
class DecompressFile implements Task
{
    /** @var string */
    private $sourcePath;
    /** @var ShellProcessor */
    private $shellProcessor;
    /** @var Compressor */
    private $compressor;

    /**
     * @param Compressor $compressor
     * @param $sourcePath
     * @param ShellProcessor $shellProcessor
     */
    public function __construct(Compressor $compressor, $sourcePath, ShellProcessor $shellProcessor)
    {
        $this->sourcePath = $sourcePath;
        $this->shellProcessor = $shellProcessor;
        $this->compressor = $compressor;
    }

    /**
     * @throws ShellProcessFailed
     */
    public function execute()
    {
        return $this->shellProcessor->process(
            Process::fromShellCommandline(
                $this->compressor->getDecompressCommandLine($this->sourcePath)
            )
        );
    }
}
