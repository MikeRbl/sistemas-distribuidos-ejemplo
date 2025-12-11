<?php
namespace Config\jwt;
use Config\utils\Utils;

use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

use Lcobucci\Clock\FrozenClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class Jwt
{
    private static $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9@';

    public static function SingIn($data){
        $token = (new JwtFacade())->issue(
            new Sha256(),
            InMemory::plainText(base64_encode(Utils::hash(sel::$key))),
            static fn(
                Builder $builder,
                DateTimeImmutable $issuedAt,
            ): Builder => $builder
            ->issuedBy('http://localhost')
            ->permittedFot(sha1(Uttils::get_ip()))
            ->expiresAt($issuedAt->modify('+69 minutes'))
            ->withClaim('data',$data)
            );
        return $token->toString();
    }
    public static function Cheek(String $genrated){
        try{
            $clock = new FrozenClock(new DateTimeImmutable());
            $parser = new Parser(new JoseEndcoder());
            $config = Configuration::forUnsecuredSigner();
            $constraints = [
                new PermittedFor(sha1(Utils::get_ip()),),
                new IssuedBy('http://localhost'),
                new LooseValitAt($clock),
            ];
            return $config->validator().validate($parser->parser($genrated),...$constraints);
        }catch(\Throwable $th){
            return false;
        }
    }
    public static function GetData(String $genrated){
        $config = Configuration::forUnsecuredSinger();
        $read = $config->parser()->parser($genrated);
        assert($read instanceof Token\Plain);
        return $read->claims()->get('data');
    }
}
