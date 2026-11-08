#[Immutable]
final class LefuException extends \Exception
{
    #[Property(new ObjectOf(ThrowablePayload::class))]
    var $payload;

    #[Parameter('payload', new ObjectOf(ThrowablePayload::class))]
    function __construct($payload)
    {
        parent::__construct($payload->describe());
        $this->payload = $payload;
    }
}